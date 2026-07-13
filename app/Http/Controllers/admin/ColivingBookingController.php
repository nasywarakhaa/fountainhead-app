<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColivingBooking;
use App\Models\ColivingRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ColivingBookingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bookings = ColivingBooking::with('colivingRoom', 'user');

            return DataTables::of($bookings)
                ->addIndexColumn()

                ->addColumn('booking_ref', function ($row) {
                    return e($row->booking_reference);
                })

                ->addColumn('room', function ($row) {
                    return e($row->colivingRoom->name ?? '-');
                })

                ->addColumn('customer', function ($row) {
                    $name  = e($row->customer_name);
                    $email = e($row->customer_email);

                    return $name . '<br><small class="text-muted">' . $email . '</small>';
                })

                ->addColumn('dates', function ($row) {
                    // date output berasal dari server, aman
                    $checkIn  = $row->check_in_date ? $row->check_in_date->format('d M Y') : '-';
                    $checkOut = $row->check_out_date ? $row->check_out_date->format('d M Y') : '-';
                    $nights   = (int) $row->total_nights;

                    return e($checkIn) . '<br><small>to</small><br>' .
                        e($checkOut) . '<br>' .
                        '<span class="badge badge-info">' . e($nights) . ' nights</span>';
                })

                ->addColumn('total', function ($row) {
                    return e('Rp ' . number_format((float) $row->total_amount, 0, ',', '.'));
                })

                ->addColumn('payment_status', function ($row) {
                    $badges = [
                        'pending'  => 'warning',
                        'paid'     => 'success',
                        'failed'   => 'danger',
                        'refunded' => 'secondary',
                    ];

                    $status = (string) $row->payment_status;
                    $badge  = $badges[$status] ?? 'secondary';

                    // status label aman
                    return '<span class="badge badge-' . $badge . '">' . e(ucfirst($status)) . '</span>';
                })

                ->addColumn('booking_status', function ($row) {
                    $badges = [
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'primary',
                        'no_show'   => 'dark',
                    ];

                    $status = (string) $row->booking_status;
                    $badge  = $badges[$status] ?? 'secondary';

                    return '<span class="badge badge-' . $badge . '">' . e(ucfirst($status)) . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $id = (int) $row->id;
                    $showUrl = route('admin.coliving-bookings.show', $id);
                    $editUrl = route('admin.coliving-bookings.edit', $id);

                    return '
                        <div class="btn-group">
                            <a href="' . e($showUrl) . '" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="' . e($editUrl) . '" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    ';
                })

                ->rawColumns(['customer', 'dates', 'payment_status', 'booking_status', 'action'])
                ->make(true);
        }

        return view('admin.coliving-bookings.index');
    }

    public function show(ColivingBooking $colivingBooking)
    {
        $colivingBooking->load('colivingRoom', 'user');
        return view('admin.coliving-bookings.show', compact('colivingBooking'));
    }

    public function edit(ColivingBooking $colivingBooking)
    {
        $rooms = ColivingRoom::available()->get();
        return view('admin.coliving-bookings.edit', compact('colivingBooking', 'rooms'));
    }

    public function update(Request $request, ColivingBooking $colivingBooking)
    {
        $validated = $request->validate([
            'payment_status'       => 'required|in:pending,paid,failed,refunded',
            'booking_status'       => 'required|in:confirmed,cancelled,completed,no_show',
            'cancellation_reason'  => 'nullable|string|max:2000',
        ]);

        // ✅ hardening: jangan simpan HTML di cancellation_reason
        if (isset($validated['cancellation_reason'])) {
            $validated['cancellation_reason'] = trim(strip_tags((string) $validated['cancellation_reason']));
        }

        // LOGIC kamu tetap: kalau dibatalkan, set cancelled_at + room available lagi
        if ($validated['booking_status'] === 'cancelled' && !$colivingBooking->cancelled_at) {
            $validated['cancelled_at'] = now();

            $colivingRoom = ColivingRoom::find($colivingBooking->coliving_room_id);
            if ($colivingRoom) {
                $colivingRoom->is_available = true;
                $colivingRoom->save();
            }
        }

        $colivingBooking->update($validated);

        return redirect()->route('admin.coliving-bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    public function stats()
    {
        $totalRevenue = ColivingBooking::where('payment_status', 'paid')->sum('total_amount');
        $confirmedBookings = ColivingBooking::where('booking_status', 'confirmed')->count();
        $pendingBookings = ColivingBooking::where('booking_status', 'pending_approval')->count();
        $monthlyBookings = ColivingBooking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return response()->json([
            'total_revenue'      => $totalRevenue,
            'confirmed_booking'  => $confirmedBookings,
            'pending_booking'    => $pendingBookings,
            'monthly_booking'    => $monthlyBookings,
        ]);
    }
}
