<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_jasa',
        'deskripsi',
        'harga',
        'kategori',
        'gambar',
    ];

    /**
     * Relasi ke User (Penyedia Jasa)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}