<?php

namespace App\Http\Controllers;

use App\Models\CafeEventBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CafeReportController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale(app()->getLocale());

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $bookings = CafeEventBooking::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        $totalBookings = $bookings->count();

        $totalRevenue = $bookings->sum('total_amount');

        $pdf = Pdf::loadView('reports.cafe-report', [
            'bookings'      => $bookings,
            'startDate'     => $startDate,
            'endDate'       => $endDate,
            'totalBookings' => $totalBookings,
            'totalRevenue'  => $totalRevenue,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream(
            'Cafe Report ' .
            $startDate->format('d-m-Y') .
            ' s.d. ' .
            $endDate->format('d-m-Y') .
            '.pdf'
        );
    }
}