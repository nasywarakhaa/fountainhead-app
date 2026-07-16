<?php

namespace App\Http\Controllers;

use App\Models\CafeEventBooking;
use App\Models\ColivingRoom;
use App\Models\ColivingBooking;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\ColivingBookingConfirmed;
class ColivingController extends Controller
{
    /**
     * Encode data to base64 (NOT security; just transport)
     */
    private function encodeData($data)
    {
        return base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE));
    }
    /**
     * Basic sanitization for user text inputs (XSS hardening)
     */
    private function cleanText($value, int $maxLen = 500)
    {
        $value = (string) $value;
        $value = trim($value);

        // remove HTML tags
        $value = strip_tags($value);

        // remove control characters (including newlines except \n,\r,\t)
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);

        // limit length
        if (mb_strlen($value) > $maxLen) {
            $value = mb_substr($value, 0, $maxLen);
        }

        return $value;
    }

    private function cleanPhone($value, int $maxLen = 20)
    {
        $value = (string) $value;
        $value = trim($value);

        // keep only digits, space, +, -, ()
        $value = preg_replace('/[^0-9+\-\s()]/', '', $value);

        if (mb_strlen($value) > $maxLen) {
            $value = mb_substr($value, 0, $maxLen);
        }

        return $value;
    }

    public function index(Request $request)
    {
        // ✅ admin control: kalau admin set off, jangan tampil di listing
        $query = ColivingRoom::query()->where('is_available', true);

        // ✅ availability berdasarkan tanggal (overlap standar)
        if ($request->filled('check_in') && $request->filled('check_out')) {
            $checkIn  = $request->check_in;
            $checkOut = $request->check_out;

            $bookedRoomIds = ColivingBooking::where('booking_status', '!=', 'cancelled')
                ->whereDate('check_in_date', '<', $checkOut)   // booking start sebelum user checkout
                ->whereDate('check_out_date', '>', $checkIn)   // booking end setelah user checkin
                ->pluck('coliving_room_id')
                ->toArray();

            if (!empty($bookedRoomIds)) {
                $query->whereNotIn('id', $bookedRoomIds);
            }
        }

        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', (float) $request->max_price);
        }

        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', (int) $request->capacity);
        }

        // whitelist sorting
        $allowedSortBy = ['sort_order', 'price_per_night', 'capacity', 'created_at', 'room_type', 'name'];
        $sortBy = $request->get('sort_by', 'sort_order');
        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'sort_order';
        }

        $sortOrder = strtolower($request->get('sort_order', 'asc'));
        $sortOrder = in_array($sortOrder, ['asc', 'desc'], true) ? $sortOrder : 'asc';

        $query->orderBy($sortBy, $sortOrder);

        // ✅ penting: biar pagination tetep bawa query filter
        $rooms = $query->paginate(12)->withQueryString();

        $roomTypes = ColivingRoom::select('room_type')->distinct()->pluck('room_type');

        $filters = $this->encodeData([
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
            'room_type' => $request->room_type,
            'max_price' => $request->max_price,
        ]);

        return view('landing.coliving.index', compact('rooms', 'roomTypes', 'filters'));
    }

    public function show(ColivingRoom $room)
    {
        if (!$room->is_available) {
            return redirect()->route('coliving.index')
                ->with('error', 'This room is currently unavailable.');
        }

        $room->load('bookings');

        $bookedDates = $room->bookings()
            ->where('booking_status', '!=', 'cancelled')
            ->get()
            ->map(function ($booking) {
                $dates = [];
                $start = Carbon::parse($booking->check_in_date);
                $end = Carbon::parse($booking->check_out_date);

                while ($start->lte($end)) {
                    $dates[] = $start->format('Y-m-d');
                    $start->addDay();
                }

                return $dates;
            })
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        $encodedBookedDates = $this->encodeData($bookedDates);

        $similarRooms = ColivingRoom::where('room_type', $room->room_type)
            ->where('id', '!=', $room->id)
            ->where('is_available', true)
            ->take(3)
            ->get();

        return view('landing.coliving.show', compact('room', 'similarRooms', 'encodedBookedDates'));
    }

    public function book(Request $request, ColivingRoom $room)
    {
        $validated = $request->validate([
            'check_in_date'    => 'required|date|after_or_equal:today',
            'check_out_date'   => 'required|date|after:check_in_date',
            'customer_phone'   => 'required|string|max:20',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        if (!$room->is_available) {
            return back()->with('error', 'This room is currently unavailable.');
        }

        // ✅ Sanitize user-provided text (XSS hardening)
        $customerName = $this->cleanText($user->name, 255);
        $customerEmail = strtolower(trim($user->email));
        $customerPhone = $this->cleanPhone($validated['customer_phone'], 20);

        // special_requests boleh multiline, tapi tetap strip tags
        $specialRequests = $this->cleanText($validated['special_requests'] ?? '', 1000);
        $specialRequests = $specialRequests !== '' ? $specialRequests : null;

        $isBooked = ColivingBooking::where('coliving_room_id', $room->id)
            ->where('booking_status', '!=', 'cancelled')
            ->whereDate('check_in_date', '<', $validated['check_out_date'])
            ->whereDate('check_out_date', '>', $validated['check_in_date'])
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'This room is already booked for the selected dates.');
        }

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $totalNights = $checkIn->diffInDays($checkOut);
        $totalAmount = $room->price_per_night * $totalNights;

        $bookingReference = 'CLV-' . strtoupper(Str::random(8)) . '-' . time();

        DB::beginTransaction();
        try {
            $booking = ColivingBooking::create([
                'booking_reference' => $bookingReference,
                'user_id'           => auth()->id(),
                'coliving_room_id'  => $room->id,
                'check_in_date'     => $validated['check_in_date'],
                'check_out_date'    => $validated['check_out_date'],
                'total_nights'      => $totalNights,
                'price_per_night'   => $room->price_per_night,
                'total_amount'      => $totalAmount,
                'customer_name'     => $customerName,
                'customer_email'    => $customerEmail,
                'customer_phone'    => $customerPhone,
                'special_requests'  => $specialRequests,

                'payment_status'    => 'pending',
                'booking_status'    => 'confirmed',
            ]);

            // kamar jadi tidak tersedia
            // $room->update(['is_available' => false]);
            DB::commit();
            Log::info('New Booking Created', [
                'encoded_reference' => $this->encodeData(['reference' => $booking->booking_reference])
            ]);
            return redirect()->route('coliving.payment', $booking->booking_reference)
                ->with('success', 'Booking created successfully! Please complete your payment.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Booking create error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create booking. Please try again.');
        }
    }
    public function myBooking()
    {
        $bookings = ColivingBooking::with('colivingRoom')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('landing.coliving.my-booking', compact('bookings'));
    }
    public function snapToken(Request $request, $bookingReference)
    {
        return DB::transaction(function () use ($bookingReference) {

            $booking = ColivingBooking::where('booking_reference', $bookingReference)
                ->lockForUpdate()
                ->with('colivingRoom')
                ->firstOrFail();

            if ($booking->payment_status === 'paid') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Booking sudah dibayar.'
                ], 409);
            }

            $now = now();
            $ttlMinutes = 120;

            $hasToken = !empty($booking->snap_token);
            $notExpired = $booking->snap_token_expires_at && $now->lt($booking->snap_token_expires_at);

            if ($hasToken && $notExpired) {
                return response()->json([
                    'ok' => true,
                    'token' => $booking->snap_token,
                    'reused' => true,
                ]);
            }

            $token = $this->generateSnapToken($booking);

            if (!$token) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Gagal membuat token Midtrans. Coba lagi.'
                ], 500);
            }

            $booking->snap_token = $token;
            $booking->snap_token_created_at = $now;
            $booking->snap_token_expires_at = $now->copy()->addMinutes($ttlMinutes);
            $booking->save();

            return response()->json([
                'ok' => true,
                'token' => $token,
                'reused' => false,
            ]);
        });
    }
    public function payment($bookingReference)
    {
        $booking = ColivingBooking::where('booking_reference', $bookingReference)
            ->with('colivingRoom')
            ->firstOrFail();
        if ($booking->payment_status === 'paid') {
            return view('landing.coliving.payment-success', compact('booking'));
        }
        return view('landing.coliving.payment', compact('booking'));
    }

    private function generateSnapToken($booking)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // NOTE: Midtrans akan render name di dashboard mereka; tetap aman kalau kamu kirim string biasa.
        $itemName = $booking->colivingRoom->name . ' - ' . $booking->total_nights . ' nights';
        $itemName = $this->cleanText($itemName, 255); // hardening

        $params = [
            'transaction_details' => [
                'order_id'      => $booking->booking_reference,
                'gross_amount'  => (int) $booking->total_amount,
            ],
            'customer_details' => [
                'first_name' => $this->cleanText($booking->customer_name, 255),
                'email'      => $booking->customer_email,
                'phone'      => $this->cleanPhone($booking->customer_phone, 20),
            ],
            'item_details' => [
                [
                    'id'       => $booking->coliving_room_id,
                    'price'    => (int) $booking->price_per_night,
                    'quantity' => (int) $booking->total_nights,
                    'name'     => $itemName,
                ]
            ],
            'callbacks' => [
                'finish' => route('coliving.payment.callback') . '?order_id=' . $booking->booking_reference,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap Token Generated', [
                'encoded_info' => $this->encodeData([
                    'booking_ref' => $booking->booking_reference,
                    'amount' => $booking->total_amount,
                    'timestamp' => now()->toDateTimeString()
                ])
            ]);

            return $snapToken;
        } catch (Exception $e) {
            Log::error('Midtrans Error', [
                'encoded_error' => $this->encodeData([
                    'message' => $e->getMessage(),
                    'booking_ref' => $booking->booking_reference
                ])
            ]);
            return null;
        }
    }

    public function paymentCallback(Request $request)
    {
        $orderId = $request->query('order_id');

        $booking = ColivingBooking::where('booking_reference', $orderId)->first();
        if (!$booking) {
            return redirect()->route('coliving.index')
                ->with('error', 'Booking not found.');
        }

        try {
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');

            $status = Transaction::status($orderId);

            Log::info('Payment Callback - Midtrans Status Check', [
                'order_id' => $orderId,
                'transaction_status' => $status->transaction_status,
                'fraud_status' => $status->fraud_status ?? 'n/a'
            ]);

            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                if ($status->transaction_status === 'settlement' ||
                    ($status->fraud_status ?? 'accept') === 'accept') {
                    $shouldSendEmail = ($booking->payment_status !== 'paid');
                    $booking->update([
                        'payment_status'     => 'paid',
                        'booking_status'     => 'confirmed',
                        'paid_at'            => now(),
                        'payment_reference'  => $status->transaction_id,
                        'snap_token' => null,
                        'snap_token_created_at' => null,
                        'snap_token_expires_at' => null,
                    ]);
                    if ($shouldSendEmail) {
                        try {
                            Mail::to($booking->customer_email)->send(
                                new ColivingBookingConfirmed($booking->fresh(['colivingRoom']))
                            );
                        } catch (Exception $e) {
                            Log::error('Failed to send booking confirmed email', [
                                'booking_reference' => $booking->booking_reference,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }

                    return redirect()->route('coliving.payment.success', $booking->booking_reference);
                }
            }

            if ($status->transaction_status === 'pending') {
                return redirect()->route('coliving.payment', $booking->booking_reference)
                    ->with('info', 'Payment is being processed...');
            }
            if (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
                $booking->update([
                    'payment_status' => 'failed',
                    'booking_status' => 'cancelled',
                    'cancelled_at'   => now(),
                    'cancellation_reason' => $status->transaction_status,
                ]);

                return redirect()->route('coliving.index')
                    ->with('error', 'Payment failed or expired. Booking has been cancelled.');
            }
            return redirect()->route('coliving.payment', $booking->booking_reference)
                ->with('error', 'Payment failed. Please try again.');
        } catch (Exception $e) {
            Log::error('Payment Callback Error', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('coliving.payment', $booking->booking_reference)
                ->with('error', 'Unable to verify payment. Please contact support.');
        }
    }

    public function paymentWebhook(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            Log::info('Coliving Webhook Received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            $booking = ColivingBooking::where('booking_reference', $orderId)->first();
            if (!$booking) {
                Log::error('Coliving Booking Not Found', ['order_id' => $orderId]);
                return response()->json(['status' => 'error'], 404);
            }

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($transactionStatus === 'settlement' || $fraudStatus === 'accept') {
                    if ($booking->payment_status !== 'paid') {
                        $booking->update([
                            'payment_status' => 'paid',
                            'booking_status' => 'confirmed',
                            'paid_at' => now(),
                            'payment_reference' => $notification->transaction_id ?? $booking->payment_reference,
                            'snap_token' => null,
                            'snap_token_created_at' => null,
                            'snap_token_expires_at' => null,
                        ]);
                        try {
                                Mail::to($booking->customer_email)->send(
                                    new ColivingBookingConfirmed($booking->fresh(['colivingRoom']))
                                );
                            } catch (Exception $e) {
                                Log::error('Failed to send booking confirmed email (webhook)', [
                                    'booking_reference' => $orderId,
                                    'error' => $e->getMessage()
                                ]);
                            }
                        Log::info('Coliving Payment Marked as PAID', [
                            'booking_reference' => $orderId
                        ]);
                    }
                }
            }

            if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $booking->update([
                    'payment_status' => 'failed',
                    'booking_status' => 'cancelled',
                    'cancelled_at'   => now(),
                    'cancellation_reason' => $transactionStatus,
                    'snap_token' => null,
                    'snap_token_created_at' => null,
                    'snap_token_expires_at' => null,
                ]);

                Log::info('Coliving Payment FAILED (booking cancelled)', [
                    'booking_reference' => $orderId,
                    'status' => $transactionStatus
                ]);
            }


            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            Log::error('Webhook Error', [
                'message' => $e->getMessage(),
                'raw' => $request->all()
            ]);
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function paymentSuccess($bookingReference)
    {
        $booking = ColivingBooking::where('booking_reference', $bookingReference)
            ->with('colivingRoom')
            ->firstOrFail();

        if ($booking->payment_status !== 'paid') {
            return redirect()->route('coliving.payment', $bookingReference)
                ->with('error', 'Payment not completed. Please complete your payment first.');
        }

        if (auth()->check() && $booking->user_id && $booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        return view('landing.coliving.payment-success', compact('booking'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id'  => 'required|exists:coliving_rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out'=> 'required|date|after:check_in',
        ]);
        $isAvailable = !ColivingBooking::where('coliving_room_id', $request->room_id)
            ->where('booking_status', '!=', 'cancelled')
            ->whereDate('check_in_date', '<', $request->check_out)
            ->whereDate('check_out_date', '>', $request->check_in)
            ->exists();
        $response = [
            'available' => $isAvailable,
            'room_id' => (int) $request->room_id,
            'dates' => [
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
            ]
        ];
        return response()->json([
            'data' => $this->encodeData($response)
        ]);
    }

    public function paymentStatus(Request $request, $bookingReference)
    {
        $booking = ColivingBooking::where('booking_reference', $bookingReference)
            ->select('booking_reference', 'payment_status', 'booking_status', 'paid_at', 'cancelled_at')
            ->first();

        if (!$booking) {
            return response()->json([
                'ok' => false,
                'message' => 'Booking not found.'
            ], 404);
        }
        // kalau paid -> front end redirect ke success
        $isPaid = ($booking->payment_status === 'paid');
        return response()->json([
            'ok' => true,
            'booking_reference' => $booking->booking_reference,
            'payment_status' => $booking->payment_status,
            'booking_status' => $booking->booking_status,
            'is_paid' => $isPaid,
            'paid_at' => $booking->paid_at ? $booking->paid_at->toDateTimeString() : null,
            'cancelled_at' => $booking->cancelled_at ? $booking->cancelled_at->toDateTimeString() : null,
        ]);
    }
}
