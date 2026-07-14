<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'booking_id',
        'sender_id',
        'message',
        'photo',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function isFromUser(): bool
    {
        return $this->sender_id === $this->booking->user_id;
    }

    public function isFromVendor(): bool
    {
        return $this->sender_id === $this->booking->vendor_id;
    }
}
