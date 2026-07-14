<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin (US3 & US5)
        User::create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Penyedia Jasa / Vendor (US2 & US4)
        User::create([
            'name' => 'Penyedia Jasa',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
        ]);

        // 3. Akun User Biasa (US1)
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}