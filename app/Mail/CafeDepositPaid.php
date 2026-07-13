<?php

namespace App\Mail;

use App\Models\CafeEventBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CafeDepositPaid extends Mailable
{
    use Queueable, SerializesModels;

    public CafeEventBooking $booking;

    public function __construct(CafeEventBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Deposit Paid - Event Booking ' . $this->booking->booking_reference)
            ->markdown('emails.cafe.deposit-paid');
    }
}
