<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCreated extends Notification
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
        return [
            'booking_id' => $this->booking->id,
            'jasa' => $this->booking->jasa->nama_jasa,
            'user' => $this->booking->user->name,
            'booking_date' => $this->booking->booking_date->format('d M Y'),
            'message' => "Booking baru untuk jasa {$this->booking->jasa->nama_jasa} dari {$this->booking->user->name}.",
        ];
    }
}
