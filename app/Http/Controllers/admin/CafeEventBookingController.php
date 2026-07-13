<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CafeEventBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CafeEventBookingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bookings = CafeEventBooking::with('user', 'approver')
                ->orderBy('created_at', 'desc');

            return DataTables::of($bookings)
                ->addIndexColumn()

                ->addColumn('booking_ref', function ($row) {
                    // escape output walau plain text
                    return e($row->booking_reference);
                })

                ->addColumn('customer', function ($row) {
                    $customerName  = e($row->customer_name);
                    $customerEmail = e($row->customer_email);
                    $org = '';

                    if (!empty($row->organization_name)) {
                        $org = '<br><small class="text-info">' . e($row->organization_name) . '</small>';
                    }

                    return $customerName . '<br><small class="text-muted">' . $customerEmail . '</small>' . $org;
                })

                ->addColumn('event_info', function ($row) {
                    $eventType = e(ucfirst((string) $row->event_type));
                    $eventName = e($row->event_name);
                    $guests    = (int) $row->expected_guests;

                    $eventTypeBadge = '<span class="badge badge-secondary">' . $eventType . '</span>';

                    return '<strong>' . $eventName . '</strong><br>' .
                        $eventTypeBadge . ' | ' . $guests . ' guests';
                })

                ->addColumn('schedule', function ($row) {
                    // tanggal/jam aman karena format server-side
                    $date = Carbon::parse($row->event_date)->format('d M Y');
                    $start = date('H:i', strtotime($row->start_time));
                    $end   = date('H:i', strtotime($row->end_time));
                    $dur   = (float) $row->duration_hours;

                    return e($date) . '<br>' .
                        '<small class="text-muted">' .
                        e($start) . ' - ' . e($end) .
                        ' (' . e($dur) . 'h)</small>';
                })

                ->addColumn('venue', function ($row) {
                    // whitelist badge color
                    $badges = [
                        'indoor'  => 'primary',
                        'outdoor' => 'success',
                        'both'    => 'info',
                    ];

                    $spaceType = (string) $row->space_type;
                    $badge = $badges[$spaceType] ?? 'secondary';

                    return '<span class="badge badge-' . $badge . '">' . e(ucfirst($spaceType)) . '</span>';
                })

                ->addColumn('total', function ($row) {
                    $total = 'Rp ' . number_format((float) $row->total_amount, 0, ',', '.');

                    if ($row->payment_status === 'dp_paid') {
                        $dp = '<br><small class="text-success">DP: Rp ' .
                            number_format((float) $row->dp_amount, 0, ',', '.') . '</small>';

                        $remaining = '<br><small class="text-warning">Sisa: Rp ' .
                            number_format((float) $row->remaining_amount, 0, ',', '.') . '</small>';

                        return e($total) . $dp . $remaining;
                    }

                    return e($total);
                })

                ->addColumn('payment_status', function ($row) {
                    $badges = [
                        'pending'  => 'warning',
                        'dp_paid'  => 'info',
                        'paid'     => 'success',
                        'failed'   => 'danger',
                        'refunded' => 'secondary',
                    ];
                    $labels = [
                        'pending'  => 'Pending',
                        'dp_paid'  => 'DP Paid',
                        'paid'     => 'Paid',
                        'failed'   => 'Failed',
                        'refunded' => 'Refunded',
                    ];

                    $status = (string) $row->payment_status;
                    $badge = $badges[$status] ?? 'secondary';
                    $label = $labels[$status] ?? ucfirst($status);

                    return '<span class="badge badge-' . $badge . '">' . e($label) . '</span>';
                })

                ->addColumn('booking_status', function ($row) {
                    $badges = [
                        'pending_approval' => 'warning',
                        'confirmed'        => 'success',
                        'cancelled'        => 'danger',
                        'completed'        => 'primary',
                    ];
                    $labels = [
                        'pending_approval' => 'Pending Approval',
                        'confirmed'        => 'Confirmed',
                        'cancelled'        => 'Cancelled',
                        'completed'        => 'Completed',
                    ];

                    $status = (string) $row->booking_status;
                    $badge = $badges[$status] ?? 'secondary';
                    $label = $labels[$status] ?? ucfirst($status);

                    return '<span class="badge badge-' . $badge . '">' . e($label) . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $id = (int) $row->id;

                    $showUrl = route('admin.cafe-bookings.show', $id);
                    $editUrl = route('admin.cafe-bookings.edit', $id);

                    $approveBtn = '';
                    if ($row->canBeApproved()) {
                        $approveBtn = '<button class="btn btn-sm btn-success approve-btn" data-id="' . $id . '">
                            <i class="fas fa-check"></i>
                        </button>';
                    }

                    return '
                        <div class="btn-group" role="group">
                            <a href="' . e($showUrl) . '" class="btn btn-sm btn-primary" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="' . e($editUrl) . '" class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            ' . $approveBtn . '
                        </div>
                    ';
                })

                ->rawColumns(['customer', 'event_info', 'schedule', 'venue', 'total', 'payment_status', 'booking_status', 'action'])
                ->make(true);
        }

        return view('admin.cafe-bookings.index');
    }

    public function show(CafeEventBooking $cafeBooking)
    {
        $cafeBooking->load('user', 'approver');
        return view('admin.cafe-bookings.show', compact('cafeBooking'));
    }

    public function edit(CafeEventBooking $cafeBooking)
    {
        return view('admin.cafe-bookings.edit', compact('cafeBooking'));
    }

    public function update(Request $request, CafeEventBooking $cafeBooking)
    {
        $validated = $request->validate([
            'payment_status'       => 'required|in:pending,dp_paid,paid,failed,refunded',
            'booking_status'       => 'required|in:pending_approval,confirmed,cancelled,completed',
            'admin_notes'          => 'nullable|string|max:2000',
            'cancellation_reason'  => 'nullable|string|max:2000',
        ]);

        // ✅ hardening: jangan simpan HTML
        if (isset($validated['admin_notes'])) {
            $validated['admin_notes'] = trim(strip_tags((string) $validated['admin_notes']));
        }
        if (isset($validated['cancellation_reason'])) {
            $validated['cancellation_reason'] = trim(strip_tags((string) $validated['cancellation_reason']));
        }

        if ($validated['booking_status'] === 'cancelled' && !$cafeBooking->cancelled_at) {
            $validated['cancelled_at'] = now();
        }

        $cafeBooking->update($validated);

        return redirect()->route('admin.cafe-bookings.index')
            ->with('success', 'Event booking updated successfully!');
    }

    public function approve(Request $request, CafeEventBooking $cafeBooking)
    {
        if (!$cafeBooking->canBeApproved()) {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be approved.'
            ], 422);
        }

        if (!CafeEventBooking::isTimeSlotAvailable(
            $cafeBooking->event_date,
            $cafeBooking->start_time,
            $cafeBooking->end_time,
            $cafeBooking->id
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Time slot is no longer available.'
            ], 422);
        }

        $cafeBooking->approve(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Booking approved successfully!'
        ]);
    }

    public function stats()
    {
        $totalRevenue = CafeEventBooking::whereIn('payment_status', ['paid', 'dp_paid'])
            ->get()
            ->sum(function ($booking) {
                return $booking->payment_status === 'paid'
                    ? $booking->total_amount
                    : $booking->dp_amount;
            });

        $confirmedBookings = CafeEventBooking::where('booking_status', 'confirmed')->count();
        $pendingBookings = CafeEventBooking::where('booking_status', 'pending_approval')->count();
        $monthlyBookings = CafeEventBooking::whereMonth('created_at', now()->month)
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
