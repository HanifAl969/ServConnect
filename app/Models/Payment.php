<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'payment_proof',
        'paid_at',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
