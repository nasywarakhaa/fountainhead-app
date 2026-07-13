<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColivingRoom;
use App\Models\ColivingBooking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_rooms' => ColivingRoom::count(),
            'available_rooms' => ColivingRoom::where('is_available', true)->count(),
            'total_bookings' => ColivingBooking::count(),
            'total_revenue' => ColivingBooking::where('payment_status', 'paid')->sum('total_amount'),
            'todays_checkins' => ColivingBooking::whereDate('check_in_date', today())
                ->where('booking_status', 'confirmed')->count(),
            'pending_payments' => ColivingBooking::where('payment_status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
