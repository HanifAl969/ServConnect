<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorCertificate extends Model
{
    protected $fillable = [
        'user_id',
        'certificate_file',
        'certificate_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fileUrl(): ?string
    {
        return $this->certificate_file
            ? asset('storage/' . $this->certificate_file)
            : null;
    }
}
