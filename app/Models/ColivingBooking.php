<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ColivingBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'coliving_room_id',
        'user_id',
        'booking_reference',
        'customer_name',
        'customer_email',
        'customer_phone',
        'check_in_date',
        'check_out_date',
        'total_nights',
        'number_of_guests',
        'price_per_night',
        'subtotal',
        'service_fee',
        'total_amount',
        'payment_status',
        'booking_status',
        'payment_reference',
        'paid_at',
        'special_requests',
        'cancellation_reason',
        'cancelled_at',
        'snap_token',
        'snap_token_created_at',
        'snap_token_expires_at',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'price_per_night' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'snap_token_created_at' => 'datetime',
        'snap_token_expires_at' => 'datetime',
    ];

    // Relasi ke ColivingRoom
    public function colivingRoom()
    {
        return $this->belongsTo(ColivingRoom::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Check if booking is active
    public function isActive()
    {
        return $this->booking_status === 'confirmed' &&
               $this->payment_status === 'paid';
    }

    // Check overlap booking untuk room yang sama
    public static function hasOverlap($roomId, $checkIn, $checkOut, $excludeBookingId = null)
    {
        $query = self::where('coliving_room_id', $roomId)
            ->where('booking_status', '!=', 'cancelled')
            ->whereDate('check_in_date', '<', $checkOut)
            ->whereDate('check_out_date', '>', $checkIn);

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->exists();
    }


    // Auto calculate total nights
    public function calculateTotalNights()
    {
        if ($this->check_in_date && $this->check_out_date) {
            $checkIn = Carbon::parse($this->check_in_date);
            $checkOut = Carbon::parse($this->check_out_date);
            $this->total_nights = $checkIn->diffInDays($checkOut);
        }
    }

    // Auto calculate pricing
    public function calculatePricing()
    {
        if ($this->total_nights && $this->price_per_night) {
            $this->subtotal = $this->total_nights * $this->price_per_night;
            $this->total_amount = $this->subtotal + $this->service_fee;
        }
    }

    // Boot method - auto calculate saat saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($booking) {
            $booking->calculateTotalNights();
            $booking->calculatePricing();
        });
    }
}
