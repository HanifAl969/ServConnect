<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingStatusChanged extends Notification
{
    use Queueable;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $statusText = $this->booking->status === 'accepted' ? 'diterima' : 'ditolak';

        return [
            'booking_id' => $this->booking->id,
            'jasa' => $this->booking->jasa->nama_jasa,
            'status' => $this->booking->status,
            'message' => "Booking untuk jasa {$this->booking->jasa->nama_jasa} telah {$statusText} oleh vendor.",
        ];
    }
}
