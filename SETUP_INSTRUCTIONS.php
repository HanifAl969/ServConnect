<?php

// ============================================================
// PETUNJUK: Tambahkan ke config/services.php yang sudah ada
// ============================================================
//
// Di dalam array return [...], tambahkan:

'openai' => [
    'key' => env('OPENAI_API_KEY'),
],

// ============================================================
// PETUNJUK: Tambahkan ke file .env
// ============================================================
//
// OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//
// SECURE CODING NOTE:
// - Jangan pernah hardcode API key di kode
// - Jangan commit .env ke GitHub
// - Pastikan .env ada di .gitignore (sudah ada secara default di Laravel)
// ============================================================


// ============================================================
// PETUNJUK: Aktifkan API routes di bootstrap/app.php
// ============================================================
//
// Ubah bagian withRouting() menjadi:
//
// ->withRouting(
//     web: __DIR__.'/../routes/web.php',
//     api: __DIR__.'/../routes/api.php',   // <-- tambahkan ini
//     commands: __DIR__.'/../routes/console.php',
//     health: '/up',
// )
//
// ============================================================


// ============================================================
// PETUNJUK: Install Laravel Sanctum untuk API authentication
// ============================================================
//
// Jalankan di terminal:
//   composer require laravel/sanctum
//   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
//   php artisan migrate
//
// Tambahkan HasApiTokens ke User model:
//   use Laravel\Sanctum\HasApiTokens;
//   class User extends Authenticatable {
//       use HasApiTokens, HasFactory, Notifiable;
//   }
// ============================================================
