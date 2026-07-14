<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Bagian ini yang ditambah/diubah, Ell!
     * Daftar kolom yang boleh diisi (Fillable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'ktp_photo',
        'vendor_type',
    ];

    /**
     * Kolom yang disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function jasas(): HasMany
    {
        return $this->hasMany(Jasa::class);
    }

    public function vendorBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'vendor_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(VendorCertificate::class);
    }

    public function ktpPhotoUrl(): ?string
    {
        return $this->ktp_photo
            ? asset('storage/' . $this->ktp_photo)
            : null;
    }

    public function vendorTypeLabel(): ?string
    {
        return match ($this->vendor_type) {
            'umkm' => 'UMKM',
            'enterprise' => 'Perusahaan Terpercaya',
            default => null,
        };
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}