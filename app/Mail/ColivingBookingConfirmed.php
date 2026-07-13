<?php

namespace App\Mail;

use App\Models\ColivingBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ColivingBookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public ColivingBooking $booking;
    public $room;

    public function __construct(ColivingBooking $booking)
    {
        // pastikan relasi room ada
        $booking->loadMissing('colivingRoom');

        $this->booking = $booking;
        $this->room = $booking->colivingRoom;
    }

    public function build()
    {
        return $this->subject('Booking Confirmed - ' . $this->booking->booking_reference)
            ->markdown('emails.coliving.booking-confirmed');
    }
}
