<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'Admin Ganteng',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate(['email' => 'vendor@gmail.com'], [
            'name' => 'Penyedia Jasa',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'status' => 'active',
            'vendor_type' => 'umkm',
            'email_verified_at' => now(),
        ]);

        $user = User::updateOrCreate(['email' => 'user@gmail.com'], [
            'name' => 'User',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $this->generateSampleKtp($user);

        $this->call(JasaSeeder::class);
        $this->call(BookingSeeder::class);
    }

    private function generateSampleKtp(User $user): void
    {
        $dir = storage_path('app/public/ktp');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'ktp_' . $user->id . '_' . time() . '.jpg';
        $path = $dir . '/' . $filename;

        $img = imagecreatetruecolor(400, 250);
        $bg = imagecolorallocate($img, 255, 255, 255);
        $blue = imagecolorallocate($img, 0, 63, 177);
        $black = imagecolorallocate($img, 0, 0, 0);
        $gray = imagecolorallocate($img, 200, 200, 200);

        imagefill($img, 0, 0, $bg);
        imagerectangle($img, 10, 10, 390, 240, $blue);
        imagestring($img, 5, 30, 30, 'KARTU TANDA PENDUDUK', $black);
        imagestring($img, 4, 30, 60, 'NIK: 3174XXXXXXXXXXXX', $black);
        imagestring($img, 4, 30, 85, 'Nama: ' . $user->name, $black);
        imagestring($img, 4, 30, 110, 'Tempat/Tgl Lahir: Jakarta, 01-01-2000', $black);
        imagestring($img, 4, 30, 135, 'Jenis Kelamin: Laki-laki', $black);
        imagestring($img, 4, 30, 160, 'Alamat: Jl. Contoh No. 123', $black);
        imagerectangle($img, 280, 30, 370, 120, $gray);

        imagejpeg($img, $path, 85);
        imagedestroy($img);

        $user->update(['ktp_photo' => 'ktp/' . $filename]);
    }
}