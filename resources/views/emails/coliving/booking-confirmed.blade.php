@component('mail::message')
# 🎉 Booking Confirmed!

Hello {{ $booking->customer_name }},

Great news! Your payment has been successfully processed and your booking at **Fountainhead Coliving** is now confirmed.

---

## 📋 Booking Information

@component('mail::table')
| Item | Details |
|:-----|:--------|
| **Booking Reference** | `{{ $booking->booking_reference }}` |
| **Room** | {{ $room->name }} |
| **Room Type** | {{ ucfirst($room->room_type) }} Room |
| **Guest** | {{ $booking->customer_name }} |
| **Email** | {{ $booking->customer_email }} |
| **Phone** | {{ $booking->customer_phone }} |
@endcomponent

---

## 📅 Stay Details

@component('mail::panel')
### Check-in
**{{ \Carbon\Carbon::parse($booking->check_in_date)->format('l, F d, Y') }}**
Time: 2:00 PM - 10:00 PM

### Check-out
**{{ \Carbon\Carbon::parse($booking->check_out_date)->format('l, F d, Y') }}**
Time: Before 12:00 PM

### Duration
**{{ $booking->total_nights }} Night{{ $booking->total_nights > 1 ? 's' : '' }}**
@endcomponent

---

## 💰 Payment Summary

@component('mail::table')
| Description | Amount |
|:------------|-------:|
| Room Rate ({{ $booking->total_nights }} night{{ $booking->total_nights > 1 ? 's' : '' }} × Rp {{ number_format($booking->price_per_night, 0, ',', '.') }}) | Rp {{ number_format($booking->price_per_night * $booking->total_nights, 0, ',', '.') }} |
| Service Fee | Rp 0 |
| **Total Paid** | **Rp {{ number_format($booking->total_amount, 0, ',', '.') }}** |
@endcomponent

✅ Payment Status: **PAID**

@if ($booking->special_requests)
---

## 📝 Your Special Requests

> {{ $booking->special_requests }}
@endif

---

@component('mail::button', ['url' => route('coliving.payment.success', $booking->booking_reference), 'color' => 'success'])
View Full Booking Details
@endcomponent

Thanks,
**The Fountainhead Team**
@endcomponent
