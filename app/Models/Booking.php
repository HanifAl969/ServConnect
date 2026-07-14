<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'jasa_id',
        'vendor_id',
        'status',
        'booking_date',
        'phone',
        'address',
        'preferred_time',
        'photos',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'photos' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jasa(): BelongsTo
    {
        return $this->belongsTo(Jasa::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
