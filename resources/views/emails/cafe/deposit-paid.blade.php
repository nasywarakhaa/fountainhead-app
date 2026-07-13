@component('mail::message')
# ✅ Deposit Payment Confirmed!

Hello {{ $booking->customer_name }},

Thank you! Your **deposit payment (DP)** has been received and your event booking is now **confirmed**.

---

## 📌 Booking Information

@component('mail::table')
| Item | Details |
|:--|:--|
| **Booking Reference** | `{{ $booking->booking_reference }}` |
| **Event Name** | {{ $booking->event_name }} |
| **Event Type** | {{ ucfirst($booking->event_type) }} |
| **Guests** | {{ $booking->expected_guests }} |
| **Space** | {{ ucfirst($booking->space_type) }} |
| **Customer** | {{ $booking->customer_name }} |
| **Email** | {{ $booking->customer_email }} |
| **Phone** | {{ $booking->customer_phone }} |
@endcomponent

---

## 🗓️ Schedule

@component('mail::panel')
**Date:** {{ \Carbon\Carbon::parse($booking->event_date)->format('l, d M Y') }}
**Time:** {{ date('H:i', strtotime($booking->start_time)) }} - {{ date('H:i', strtotime($booking->end_time)) }} ({{ $booking->duration_hours }}h)
@endcomponent

---

## 💰 Payment Summary

@component('mail::table')
| Description | Amount |
|:--|--:|
| **Deposit Paid (DP)** | **Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}** |
| Remaining Payment (pay at cafe) | Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }} |
@endcomponent

✅ Payment Status: **DP PAID**

---

@if(!empty($booking->special_requirements))
## 📝 Special Requirements
> {{ $booking->special_requirements }}
@endif

---

@component('mail::button', ['url' => route('cafe.payment.success', $booking->booking_reference)])
View Booking Status
@endcomponent

---

If you have questions, reply to our support contact.

Warm regards,
**Fountainhead Team**
@endcomponent
