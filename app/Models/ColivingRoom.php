<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ColivingRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'room_type',
        'description',
        'short_description',
        'price_per_night',
        'weekly_price',
        'monthly_price',
        'capacity',
        'room_size',
        'beds_count',
        'bed_type',
        'floor',
        'has_window',
        'has_balcony',
        'bathroom_type',
        'facilities',
        'amenities',
        'thumbnail',
        'images',
        'is_available',
        'total_units',
        'cancellation_policy',
        'house_rules',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'facilities' => 'array',
        'amenities' => 'array',
        'images' => 'array',
        'is_available' => 'boolean',
        'has_window' => 'boolean',
        'has_balcony' => 'boolean',
        'is_featured' => 'boolean',
        'price_per_night' => 'decimal:2',
        'weekly_price' => 'decimal:2',
        'monthly_price' => 'decimal:2',
        'room_size' => 'decimal:2',
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->slug)) {
                $room->slug = Str::slug($room->name);
            }
        });

        static::updating(function ($room) {
            if ($room->isDirty('name') && empty($room->slug)) {
                $room->slug = Str::slug($room->name);
            }
        });
    }

    // Relasi ke ColivingBooking
    public function bookings()
    {
        return $this->hasMany(ColivingBooking::class);
    }

    // Get active bookings
    public function activeBookings()
    {
        return $this->hasMany(ColivingBooking::class)
            ->where('booking_status', 'confirmed')
            ->where('payment_status', 'paid');
    }

    // Check availability untuk tanggal tertentu
    public function isAvailableForDates($checkIn, $checkOut)
    {
        if (!$this->is_available) {
            return false;
        }

        return !ColivingBooking::hasOverlap($this->id, $checkIn, $checkOut);
    }

    // Get unavailable dates untuk calendar
    public function getUnavailableDates()
    {
        return $this->bookings()
            ->where('booking_status', '!=', 'cancelled')
            ->select('check_in_date', 'check_out_date')
            ->get();
    }

    // Calculate price based on duration
    public function calculatePrice($nights)
    {
        // Kalau booking monthly (30+ hari) dan ada monthly price
        if ($nights >= 30 && $this->monthly_price) {
            $months = floor($nights / 30);
            $remainingDays = $nights % 30;
            return ($months * $this->monthly_price) + ($remainingDays * $this->price_per_night);
        }

        // Kalau booking weekly (7+ hari) dan ada weekly price
        if ($nights >= 7 && $this->weekly_price) {
            $weeks = floor($nights / 7);
            $remainingDays = $nights % 7;
            return ($weeks * $this->weekly_price) + ($remainingDays * $this->price_per_night);
        }

        // Default daily rate
        return $nights * $this->price_per_night;
    }

    // Get room type label
    public function getRoomTypeLabel()
    {
        return match($this->room_type) {
            'single' => 'Single Room',
            'double' => 'Double Room',
            'shared' => 'Shared Room',
            'suite' => 'Suite',
            'dormitory' => 'Dormitory',
            default => $this->room_type,
        };
    }

    // Get bed type label
    public function getBedTypeLabel()
    {
        return match($this->bed_type) {
            'single' => 'Single Bed',
            'double' => 'Double Bed',
            'queen' => 'Queen Bed',
            'king' => 'King Bed',
            'bunk' => 'Bunk Bed',
            default => $this->bed_type,
        };
    }

    // Scope untuk featured rooms
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope untuk available rooms
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope sorting by price
    public function scopeCheapest($query)
    {
        return $query->orderBy('price_per_night', 'asc');
    }

    public function scopeMostExpensive($query)
    {
        return $query->orderBy('price_per_night', 'desc');
    }
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = self::normalizeRoomText($value, 5000);
    }

    public function setHouseRulesAttribute($value)
    {
        $this->attributes['house_rules'] = self::normalizeRoomText($value, 5000);
    }

    public function setCancellationPolicyAttribute($value)
    {
        $this->attributes['cancellation_policy'] = self::normalizeRoomText($value, 8000);
    }

    // accessor: versi siap render (lead + items) tanpa Blade @php
    protected $appends = [
        'description_view',
        'house_rules_view',
        'cancellation_policy_view',
    ];

    public function getDescriptionViewAttribute(): array
    {
        return self::splitLeadAndBullets($this->description);
    }

    public function getHouseRulesViewAttribute(): array
    {
        return self::splitLeadAndBullets($this->house_rules);
    }

    public function getCancellationPolicyViewAttribute(): array
    {
        return self::splitLeadAndBullets($this->cancellation_policy);
    }

    private static function splitLeadAndBullets($value): array
    {
        $text = trim((string) $value);
        if ($text === '') return ['lead' => null, 'items' => []];

        $text = str_replace(["\r\n", "\r"], "\n", $text);

        // split bullet yang formatnya: "\n• " atau "\n•" atau "• "
        if (preg_match("/(?:^|\n)\s*•\s*/u", $text)) {
            $parts = preg_split("/(?:^|\n)\s*•\s*/u", $text);
            $parts = array_values(array_filter(array_map('trim', $parts), fn($v) => $v !== ''));

            $lead = array_shift($parts);
            return ['lead' => $lead ?: null, 'items' => $parts];
        }

        return ['lead' => $text, 'items' => []];
    }

    private static function normalizeRoomText($value, int $maxLen = 5000): string
    {
        $text = trim((string) $value);
        if ($text === '') return '';

        $text = strip_tags($text);
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        $text = preg_replace("/[ \t]+/u", " ", $text);
        $text = preg_replace("/\n[ \t]+/u", "\n", $text);
        $text = preg_replace("/[ \t]+\n/u", "\n", $text);

        // 1. xxx => \n• xxx
        $text = preg_replace('/(?:^|\n)\s*\d+\.\s+/u', "\n• ", $text);
        // - xxx => \n• xxx
        $text = preg_replace('/(?:^|\n)\s*-\s+/u', "\n• ", $text);
        // • rapihin jadi \n• xxx
        $text = preg_replace('/\s*•\s*/u', "\n• ", $text);
        // ngilangin double bullet
        $text = preg_replace("/^\n+/u", "", $text);
        // ini yang ngilangin gap kebawah
        $text = preg_replace("/\n{3,}/u", "\n\n", $text);

        $text = trim($text);

        if (mb_strlen($text) > $maxLen) {
            $text = mb_substr($text, 0, $maxLen);
        }

        return $text;
    }
}
