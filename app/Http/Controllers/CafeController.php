<?php

namespace App\Http\Controllers;

use App\Models\CafeEventBooking;
use App\Models\Galleries;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\CafeDepositPaid;
class CafeController extends Controller
{
    /**
     * Basic sanitization to prevent stored XSS
     */
    private function cleanText($value, int $maxLen = 500)
    {
        $value = (string) $value;
        $value = trim($value);

        // remove HTML tags
        $value = strip_tags($value);

        // remove control characters (except common whitespace)
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);

        if (mb_strlen($value) > $maxLen) {
            $value = mb_substr($value, 0, $maxLen);
        }

        return $value;
    }

    private function cleanPhone($value, int $maxLen = 20)
    {
        $value = (string) $value;
        $value = trim($value);
        $value = preg_replace('/[^0-9+\-\s()]/', '', $value);

        if (mb_strlen($value) > $maxLen) {
            $value = mb_substr($value, 0, $maxLen);
        }

        return $value;
    }

    public function index()
    {
        $galleries = Galleries::byCategory('cafe')->orderBy('sort_order')->get();
        $eventGalleries = Galleries::byCategory('event')->orderBy('sort_order')->get();

        return view('landing.cafe.index', compact('galleries', 'eventGalleries'));
    }

    public function bookEvent()
    {
        return view('landing.cafe.book', compact(
        ));
    }

    public function storeBooking(Request $request)
    {
        // 1) Validasi sesuai Migration
        $validated = $request->validate([
            'event_name'             => 'required|string|max:255',
            'event_type'             => 'required|in:birthday,meeting,workshop,party,wedding,corporate,other',
            'event_date'             => 'required|date|after_or_equal:today',
            'start_time'             => 'required|date_format:H:i',
            'end_time'               => 'required|date_format:H:i|after:start_time',
            'expected_guests'        => 'required|integer|min:1|max:100',
            'space_type'             => 'required|in:indoor,outdoor,both',
            'customer_name'          => 'required|string|max:255',
            'customer_email'         => 'required|email|max:255',
            'customer_phone'         => 'required|string|max:20',
            'organization_name'      => 'nullable|string|max:255',
            'event_description'      => 'nullable|string|max:2000',
            'special_requirements'   => 'nullable|string|max:2000',
            'additional_services'    => 'nullable|array',
        ]);

        // 2) Cek Ketersediaan Waktu (logic tetap)
        if (!CafeEventBooking::isTimeSlotAvailable(
            $validated['event_date'],
            $validated['start_time'],
            $validated['end_time']
        )) {
            return back()->with('error', 'This time slot is not available. Please choose a different time.');
        }

        $bookingReference = 'CFE-' . strtoupper(Str::random(8)) . '-' . time();

        // ✅ XSS hardening: sanitize fields that can be displayed later
        $eventName = $this->cleanText($validated['event_name'], 255);
        $customerName = $this->cleanText($validated['customer_name'], 255);
        $orgName = $this->cleanText($validated['organization_name'] ?? '', 255);
        $orgName = $orgName !== '' ? $orgName : null;

        $eventDesc = $this->cleanText($validated['event_description'] ?? '', 2000);
        $eventDesc = $eventDesc !== '' ? $eventDesc : 'No description';

        $specialReq = $this->cleanText($validated['special_requirements'] ?? '', 2000);
        $specialReq = $specialReq !== '' ? $specialReq : null;

        $customerEmail = strtolower(trim((string) $validated['customer_email'])); // already validated as email
        $customerPhone = $this->cleanPhone($validated['customer_phone'], 20);

        // additional_services array: normalize to array of safe strings
        $services = $validated['additional_services'] ?? [];
        if (!is_array($services)) $services = [];
        $services = array_values(array_filter(array_map(function ($v) {
            return $this->cleanText($v, 100);
        }, $services), fn($v) => $v !== ''));

        // 3) Create Booking (logic tetap)
        $booking = CafeEventBooking::create([
            'booking_reference'     => $bookingReference,
            'user_id'               => auth()->id() ?? null,

            'event_name'            => $eventName,
            'event_type'            => $validated['event_type'],
            'event_description'     => $eventDesc,

            'event_date'            => $validated['event_date'],
            'start_time'            => $validated['start_time'],
            'end_time'              => $validated['end_time'],
            'expected_guests'       => (int) $validated['expected_guests'],
            'space_type'            => $validated['space_type'],

            'customer_name'         => $customerName,
            'customer_email'        => $customerEmail,
            'customer_phone'        => $customerPhone,

            'organization_name'     => $orgName,
            'special_requirements'  => $specialReq,
            'additional_services'   => $services,

            'payment_status'        => 'pending',
            'booking_status'        => 'pending_approval',
        ]);

        $booking->refresh();

        return redirect()->route('cafe.payment', $booking->booking_reference)
            ->with('success', 'Event booking created successfully! Please pay the deposit to confirm your booking.');
    }

    public function snapToken(Request $request, $bookingReference)
    {
        return DB::transaction(function () use ($bookingReference) {
            $booking = CafeEventBooking::where('booking_reference', $bookingReference)
                ->lockForUpdate()
                ->firstOrFail();
            if ($booking->payment_status === 'dp_paid') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Deposit sudah dibayar.'
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

    public function invoice($reference)
    {
        $booking = CafeEventBooking::where('booking_reference', $reference)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!in_array($booking->payment_status, ['paid', 'dp_paid'])) {
            abort(403);
        }

        $pdf = Pdf::loadView(
            'landing.invoices.invoice-cafe',
            compact('booking')
        );

        return $pdf->stream(
            'Invoice-'.$booking->booking_reference.'.pdf'
        );
    }

    public function payment($bookingReference)
        {
        $booking = CafeEventBooking::where('booking_reference', $bookingReference)->firstOrFail();

        if ($booking->payment_status === 'dp_paid') {
            return redirect()->route('cafe.payment.success', $booking->booking_reference);
        }
        return view('landing.cafe.payment', compact('booking'));
    }

    private function generateSnapToken($booking)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // DP 50% (logic tetap)
        $amount = $booking->dp_amount;
        $description = 'Deposit Payment (50%) - Pay remaining at cafe';

        if ($amount <= 0) {
            Log::error('Generate Snap Token Error: Amount is zero or less.', ['booking_id' => $booking->id]);
            return null;
        }

        $orderId = $booking->booking_reference;

        $itemName = $this->cleanText($booking->event_name, 255) . ' - ' . $this->cleanText($description, 255);

        $params = [
            'transaction_details' => [
                'order_id'      => $orderId,
                'gross_amount'  => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $this->cleanText($booking->customer_name, 255),
                'email'      => $booking->customer_email,
                'phone'      => $this->cleanPhone($booking->customer_phone, 20),
            ],
            'item_details' => [
                [
                    'id'       => $booking->id . '-DP',
                    'price'    => (int) $amount,
                    'quantity' => 1,
                    'name'     => $itemName,
                ]
            ],
            'callbacks' => [
                'finish' => route('cafe.payment.callback') . '?order_id=' . $orderId,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap Token Generated', [
                'booking_reference' => $booking->booking_reference,
                'amount' => $amount,
                'order_id' => $orderId
            ]);

            return $snapToken;
        } catch (Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage(), ['booking_id' => $booking->id]);
            return null;
        }
    }

    public function paymentCallback(Request $request)
    {
        $orderId = $request->query('order_id');

        $booking = CafeEventBooking::where('booking_reference', $orderId)->first();
        if (!$booking) {
            return redirect()->route('cafe.index')
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
                    $shouldSendEmail = ($booking->payment_status !== 'dp_paid');
                    $booking->update([
                        'payment_status'     => 'dp_paid',
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
                                new CafeDepositPaid($booking->fresh())
                            );
                        } catch (Exception $e) {
                            Log::error('Failed to send Cafe DP email (callback)', [
                                'booking_reference' => $booking->booking_reference,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                    return redirect()->route('cafe.payment.success', $booking->booking_reference);
                }
            }

            if ($status->transaction_status === 'pending') {
                return redirect()->route('cafe.payment', $booking->booking_reference)
                    ->with('info', 'Payment is being processed...');
            }

            return redirect()->route('cafe.payment', $booking->booking_reference)
                ->with('error', 'Payment failed. Please try again.');
        } catch (Exception $e) {
            Log::error('Payment Callback Error', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('cafe.payment', $booking->booking_reference)
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
            $paymentType = $notification->payment_type ?? 'unknown';
            $transactionId = $notification->transaction_id ?? null;

            Log::info('Midtrans Webhook Received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType,
                'transaction_id' => $transactionId,
            ]);

            $booking = CafeEventBooking::where('booking_reference', $orderId)->first();
            if (!$booking) {
                Log::error('Booking not found', ['booking_reference' => $orderId]);
                return response()->json(['status' => 'error'], 404);
            }

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($transactionStatus === 'settlement' || $fraudStatus === 'accept') {
                    if ($booking->payment_status === 'pending') {
                        $booking->update([
                            'payment_status'    => 'dp_paid',
                            'booking_status'    => 'confirmed',
                            'payment_reference' => $transactionId,
                            'paid_at'           => now(),
                            'snap_token' => null,
                            'snap_token_created_at' => null,
                            'snap_token_expires_at' => null,
                        ]);
                        try {
                                Mail::to($booking->customer_email)->send(
                                    new CafeDepositPaid($booking->fresh())
                                );
                            } catch (Exception $e) {
                                Log::error('Failed to send Cafe DP email (webhook)', [
                                    'booking_reference' => $orderId,
                                    'error' => $e->getMessage()
                                ]);
                            }
                        Log::info('DP Payment updated', [
                            'booking_reference' => $orderId,
                        ]);
                    }
                }
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $booking->update([
                    'payment_status'     => 'failed',
                    'payment_reference'  => $transactionId,
                    'snap_token' => null,
                    'snap_token_created_at' => null,
                    'snap_token_expires_at' => null,
                ]);

                Log::info('Payment failed', [
                    'booking_reference' => $orderId,
                    'status' => $transactionStatus
                ]);
            }

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            Log::error('Webhook error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    public function paymentSuccess($bookingReference)
    {
        $booking = CafeEventBooking::where('booking_reference', $bookingReference)->firstOrFail();

        if (!in_array($booking->payment_status, ['paid', 'dp_paid'], true)) {
            return redirect()->route('cafe.payment', $bookingReference)
                ->with('error', 'Payment not completed. Please complete your payment first.');
        }

        if (auth()->check() && $booking->user_id && $booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        return view('landing.cafe.payment-success', compact('booking'));
    }
    public function paymentStatus(Request $request, $bookingReference)
    {
        $booking = CafeEventBooking::where('booking_reference', $bookingReference)
            ->select('booking_reference', 'payment_status', 'booking_status', 'paid_at', 'cancelled_at')
            ->first();

        if (!$booking) {
            return response()->json([
                'ok' => false,
                'message' => 'Booking not found.'
            ], 404);
        }

        $isPaid = ($booking->payment_status === 'dp_paid');

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
    public function menu()
    {
        return view('landing.cafe.menu');
    }
}
