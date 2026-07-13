<?php

namespace App\Models;

use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CafeEventBooking extends Model
{
    use HasFactory;

    /**
     * 1. $fillable LENGKAP
     * Ini memperbaiki error 'Field ... doesn't have a default value'
     */
    protected $fillable = [
        'booking_reference',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'organization_name',
        'event_name',
        'event_description',
        'event_type',
        'expected_guests',
        'event_date',
        'start_time',
        'end_time',
        'space_type',
        'additional_services',
        'special_requirements',
        'payment_status',
        'booking_status',
        'snap_token',
        'snap_token_created_at',
        'snap_token_expires_at',
        // Field harga dan durasi
        'duration_hours',
        'venue_price',
        'services_price',
        'subtotal',
        'tax',
        'total_amount',
        'dp_amount',
        'remaining_amount',

        // Field admin
        'payment_reference',
        'paid_at',
        'admin_notes',
        'cancellation_reason',
        'cancelled_at',
        'approved_at',
        'approved_by',
    ];

    /**
     * 2. $casts DIPERBAIKI
     * Ini memperbaiki error 'Double date specification'.
     * 'start_time' dan 'end_time' adalah 'time' (H:i), BUKAN 'datetime'.
     */
    protected $casts = [
        'event_date' => 'string', // <-- SUDAH BENAR
        'start_time' => TimeCast::class,
        'end_time' => TimeCast::class,
        'additional_services' => 'array',
        'venue_price' => 'decimal:2',
        'services_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'approved_at' => 'datetime',
        'snap_token_created_at' => 'datetime',
        'snap_token_expires_at' => 'datetime',
    ];

    // Relasi ke User (yang booking)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke User (yang approve)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessor untuk booking reference (jika diperlukan, tapi controller sudah set)
    // public function getBookingReferenceAttribute()
    // {
    //     return 'CEV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    // }

    /**
     * 3. isTimeSlotAvailable DIPERBAIKI
     * Membandingkan time string dengan benar
     */
    public static function isTimeSlotAvailable($eventDate, $startTime, $endTime, $excludeBookingId = null)
    {
        // Konversi H:i string ke format time 'H:i:s'
        $start = Carbon::parse($startTime)->format('H:i:s');
        $end = Carbon::parse($endTime)->format('H:i:s');

        $query = self::where('event_date', $eventDate)
            ->where('booking_status', '!=', 'cancelled')
            ->where(function ($q) use ($start, $end) {
                // (StartA < EndB) and (EndA > StartB)
                $q->where('start_time', '<', $end)
                  ->where('end_time', '>', $start);
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return !$query->exists();
    }

    /**
     * 4. calculateDuration DIPERBAIKI
     * Ini memperbaiki error parsing dan 'Data truncated'
     */
    public function calculateDuration()
    {
        if ($this->start_time && $this->end_time) {
            // $this->start_time sekarang adalah string 'H:i' (e.g., '10:34')
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);

            $minutes = $start->diffInMinutes($end);

            // BULATKAN KE ATAS dan jadikan INTEGER (sesuai migration)
            $this->duration_hours = (int) ceil($minutes / 60);
        }
    }

    /**
     * 5. calculatePricing DIPERBAIKI
     * Ini memperbaiki harga 0
     */
    public function calculatePricing()
    {
        // === LOGIKA A (Harga Per Jam) ===
        $baseRate = 150000; // Harga per jam
        // Ambil durasi yang SUDAH dihitung oleh calculateDuration()
        $duration = $this->duration_hours ?? 0;

        $this->venue_price = $baseRate * $duration;

        // Tambahan untuk space_type
        if ($this->space_type === 'outdoor') {
            $this->venue_price += 50000;
        } elseif ($this->space_type === 'both') {
            $this->venue_price += 100000;
        }

        // TODO: Tambahkan logika harga 'additional_services' jika perlu
        $this->services_price = 0;

        // === Kalkulasi Total ===
        $this->subtotal = $this->venue_price + $this->services_price;
        $this->tax = $this->subtotal * 0.11; // PPN 11%
        $this->total_amount = $this->subtotal + $this->tax;

        // Calculate DP 50%
        $this->dp_amount = $this->total_amount * 0.5;
        $this->remaining_amount = $this->total_amount - $this->dp_amount;
    }

    // Check apakah bisa di-approve
    public function canBeApproved()
    {
        return $this->booking_status === 'pending_approval' &&
               $this->payment_status !== 'failed';
    }

    // Method approve booking
    public function approve($userId)
    {
        $this->booking_status = 'confirmed';
        $this->approved_at = now();
        $this->approved_by = $userId;
        $this->save();
    }

    /**
     * 6. boot() method
     * Memastikan kalkulasi dijalankan saat 'saving'
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($booking) {
            // Jalankan kalkulasi durasi DULU
            $booking->calculateDuration();
            // JALANKAN kalkulasi harga SETELAHNYA
            $booking->calculatePricing();
        });
    }
}
