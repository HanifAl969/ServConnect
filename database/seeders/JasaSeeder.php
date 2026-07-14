<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jasa;
use App\Models\VendorCertificate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JasaSeeder extends Seeder
{
    public function run(): void
    {
        $storagePath = public_path('storage/jasa');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $certDir = storage_path('app/public/certificates');
        if (!is_dir($certDir)) {
            mkdir($certDir, 0755, true);
        }

        $vendors = [
            // --- CLEANING (existing + 2 new = 3 vendors, total 10 jasa) ---
            [
                'name' => 'Bersih Bersinar',
                'email' => 'bersih@gmail.com',
                'vendor_type' => 'enterprise',
                'kategori' => 'Cleaning',
                'jasas' => [
                    ['nama_jasa' => 'Cuci AC 1-2 PK', 'harga' => 150000, 'deskripsi' => 'Pembersihan AC secara profesional meliputi cuci evaporator, kondensor, dan filter. Hasil dingin maksimal, tagihan listrik lebih hemat.'],
                    ['nama_jasa' => 'Laundry Express', 'harga' => 55000, 'deskripsi' => 'Layanan laundry kiloan dengan estimasi selesai 6 jam. Cuci, setrika, lipit rapi. Antar-jemput gratis area Jabodetabek.'],
                    ['nama_jasa' => 'Cleaning Rumah', 'harga' => 250000, 'deskripsi' => 'Bersihkan total rumah tinggal tipe 36-45. Meliputi sapu, pel, lap kaca, bersihkan kamar mandi, dan dapur.'],
                    ['nama_jasa' => 'Cuci Mobil & Motor', 'harga' => 350000, 'deskripsi' => 'Cuci mobil dan motor lengkap dengan shampo premium, lap microfiber, dan wax kilap. Antar-jemput gratis area Jabodetabek.'],
                    ['nama_jasa' => 'Paket Kebersihan Kantor', 'harga' => 500000, 'deskripsi' => 'Bersihkan total area kantor ukuran 50-100 m2. Meliputi meja, kursi, lantai, kaca, dan toilet.'],
                ],
            ],
            [
                'name' => 'CleanPro',
                'email' => 'cleanpro@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Cleaning',
                'jasas' => [
                    ['nama_jasa' => 'Cuci Sofa 3 Seater', 'harga' => 200000, 'deskripsi' => 'Pencucian sofa berbahan kain dengan metode dry clean. Wangi, bebas debu dan tungau.'],
                    ['nama_jasa' => 'Fogging Disinfektan', 'harga' => 350000, 'deskripsi' => 'Fogging ruangan untuk membunuh virus, bakteri, dan jamur. Cocok untuk kantor dan rumah sakit.'],
                    ['nama_jasa' => 'Cuci Karpet Kantor', 'harga' => 500000, 'deskripsi' => 'Pembersihan karpet area kerja dengan mesin ekstraktor profesional. Cepat kering.'],
                    ['nama_jasa' => 'Poles Marmer & Granit', 'harga' => 750000, 'deskripsi' => 'Poles lantai marmer dan granit mengkilap kembali. Termasuk coating pelindung.'],
                ],
            ],
            [
                'name' => 'FreshHome',
                'email' => 'freshhome@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Cleaning',
                'jasas' => [
                    ['nama_jasa' => 'Cuci Spring Bed', 'harga' => 180000, 'deskripsi' => 'Cuci spring bed ukuran king/queen dengan metode dry cleaning. Bebas tungau dan noda.'],
                    ['nama_jasa' => 'Bersihkan Tandon Air', 'harga' => 300000, 'deskripsi' => 'Pengurasan dan pembersihan tandon air ukuran 500-1000 liter. Selesai dalam 2 jam.'],
                    ['nama_jasa' => 'Laundry Bed Cover', 'harga' => 120000, 'deskripsi' => 'Cuci bed cover dan selimut ukuran besar. Antar-jemput gratis.'],
                ],
            ],
            // --- REPAIR (existing + 2 new = 3 vendors, total 10 jasa) ---
            [
                'name' => 'Teknisi Handal',
                'email' => 'teknisi@gmail.com',
                'vendor_type' => 'enterprise',
                'kategori' => 'Repair',
                'jasas' => [
                    ['nama_jasa' => 'Servis Kulkas & Freezer', 'harga' => 200000, 'deskripsi' => 'Perbaikan kulkas mati total, kurang dingin, bocor freon. Termasuk cek kompresor dan penggantian spare part ringan.'],
                    ['nama_jasa' => 'Perbaikan Pipa Air', 'harga' => 175000, 'deskripsi' => 'Atasi pipa bocor, mampet, instalasi ulang pipa air kotor dan bersih. Berpengalaman menangani rumah dan apartemen.'],
                    ['nama_jasa' => 'Renovasi Kamar Minimalis', 'harga' => 3500000, 'deskripsi' => 'Renovasi total kamar tidur ukuran 3x4. Termasuk plafon, cat dinding, lantai vinyl, dan instalasi listrik baru.'],
                    ['nama_jasa' => 'Instalasi Listrik Rumah', 'harga' => 450000, 'deskripsi' => 'Instalasi listrik baru untuk rumah tinggal. Termasuk kabel, saklar, stop kontak, dan MCB. Standar PLN.'],
                    ['nama_jasa' => 'Servis Pompa Air', 'harga' => 125000, 'deskripsi' => 'Perbaiki pompa air mati, tidak kuat dorong, atau bocor. Cek dinamo, karet membran, dan pipa.'],
                ],
            ],
            [
                'name' => 'FixMaster',
                'email' => 'fixmaster@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Repair',
                'jasas' => [
                    ['nama_jasa' => 'Pasang AC Split Baru', 'harga' => 600000, 'deskripsi' => 'Instalasi AC split 1-2 PK lengkap dengan bracket, pipa, dan kabel standar.'],
                    ['nama_jasa' => 'Servis Mesin Cuci', 'harga' => 150000, 'deskripsi' => 'Perbaiki mesin cuci 1 dan 2 tabung. Motor, timer, atau pipa bocor.'],
                    ['nama_jasa' => 'Ganti Kunci Pintu', 'harga' => 120000, 'deskripsi' => 'Ganti kunci pintu rumah atau kamar dengan kunci baru. Termasuk pemasangan.'],
                    ['nama_jasa' => 'Perbaikan Water Heater', 'harga' => 180000, 'deskripsi' => 'Servis water heater listrik dan gas. Atasi tidak panas, bocor, atau mati total.'],
                ],
            ],
            [
                'name' => 'BengkelKita',
                'email' => 'bengkelkita@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Repair',
                'jasas' => [
                    ['nama_jasa' => 'Cat Ulang Kusen & Jendela', 'harga' => 450000, 'deskripsi' => 'Cat ulang kusen kayu dan jendela. Amplas, dempul, dan cat finishing.'],
                    ['nama_jasa' => 'Perbaikan Plafon Bocor', 'harga' => 350000, 'deskripsi' => 'Perbaiki plafon gypsum bocor akibat atap atau pipa. Termasuk pengecatan ulang.'],
                    ['nama_jasa' => 'Pasang Keramik Lantai', 'harga' => 800000, 'deskripsi' => 'Pasang keramik lantai ukuran 40x40. Termasuk nat dan finishing rapi.'],
                ],
            ],
            // --- CREATIVE (existing + 2 new = 3 vendors, total 10 jasa) ---
            [
                'name' => 'Kreatif Studio',
                'email' => 'kreatif@gmail.com',
                'vendor_type' => 'enterprise',
                'kategori' => 'Creative',
                'jasas' => [
                    ['nama_jasa' => 'Desain Logo Premium', 'harga' => 750000, 'deskripsi' => 'Desain logo original dengan 3 alternatif konsep. Revisi tak terbatas, file siap cetak (AI, PNG, JPG, SVG).'],
                    ['nama_jasa' => 'Paket Fotografi Wisuda', 'harga' => 1500000, 'deskripsi' => 'Sesi foto indoor/outdoor, 50+ foto edit profesional, 1 album cetak 20 halaman, dan 1 bingkai foto ukuran 20R.'],
                    ['nama_jasa' => 'Copywriting Web/Blog', 'harga' => 400000, 'deskripsi' => 'Penulisan 5 artikel SEO-friendly untuk website atau blog perusahaan. Riset keyword, judul menarik, konten orisinal 500-800 kata.'],
                    ['nama_jasa' => 'Motion Graphic Animasi', 'harga' => 1200000, 'deskripsi' => 'Animasi motion graphic durasi 60 detik. Cocok untuk iklan, penjelasan produk, atau konten media sosial.'],
                    ['nama_jasa' => 'Desain Kemasan Produk', 'harga' => 600000, 'deskripsi' => 'Desain kemasan produk makanan/minuman. Termasuk label, box, dan mockup 3D. Siap cetak.'],
                ],
            ],
            [
                'name' => 'DesainGrafisID',
                'email' => 'desaingrafis@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Creative',
                'jasas' => [
                    ['nama_jasa' => 'Paket Social Media Design', 'harga' => 600000, 'deskripsi' => '10 desain feed Instagram + 5 story. Konsisten dengan brand guidelines. Format siap upload.'],
                    ['nama_jasa' => 'Desain Banner & Flyer', 'harga' => 350000, 'deskripsi' => 'Desain banner X-stand, brosur, flyer A4. Cetak resolusi tinggi, revisi 3x.'],
                    ['nama_jasa' => 'Ulang Tahun Anak', 'harga' => 2000000, 'deskripsi' => 'Paket fotografi ulang tahun anak. 2 jam sesi, 30 foto edit, dan 1 cetak album.'],
                    ['nama_jasa' => 'Desain UI/UX Aplikasi', 'harga' => 2500000, 'deskripsi' => 'Desain antarmuka aplikasi mobile/web. Wireframe, prototype interaktif, siap develop.'],
                ],
            ],
            [
                'name' => 'FotoKeren',
                'email' => 'fotokeren@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Creative',
                'jasas' => [
                    ['nama_jasa' => 'Paket Prewedding', 'harga' => 3500000, 'deskripsi' => 'Sesi foto prewedding 2 lokasi, 2 outfit, 100+ foto edit. Album premium 30 halaman.'],
                    ['nama_jasa' => 'Video Company Profile', 'harga' => 5000000, 'deskripsi' => 'Video company profile durasi 3-5 menit. Termasuk script, shooting, editing, dan musik.'],
                    ['nama_jasa' => 'Editing Video Reels', 'harga' => 250000, 'deskripsi' => 'Edit video pendek untuk Instagram Reels/TikTok. Efek, caption, dan musik.'],
                ],
            ],
            // --- BUSINESS (existing + 2 new = 3 vendors, total 10 jasa) ---
            [
                'name' => 'Konsultan Pro',
                'email' => 'konsultan@gmail.com',
                'vendor_type' => 'enterprise',
                'kategori' => 'Business',
                'jasas' => [
                    ['nama_jasa' => 'Konsultasi Pajak Tahunan', 'harga' => 350000, 'deskripsi' => 'Hitung dan lapor SPT tahunan PPh 21/25, konsultasi perencanaan pajak, dan pendampingan pemeriksaan pajak.'],
                    ['nama_jasa' => 'Akta Pendirian CV/PT', 'harga' => 2500000, 'deskripsi' => 'Pengurusan legalitas usaha mulai dari akta notaris, SK Kemenkumham, NPWP badan, hingga NIB lengkap.'],
                    ['nama_jasa' => 'Konsultasi Bisnis UMKM', 'harga' => 500000, 'deskripsi' => 'Sesi konsultasi bisnis 90 menit mencakup analisis SWOT, strategi pemasaran, dan perencanaan keuangan untuk UMKM.'],
                    ['nama_jasa' => 'Analisis Laporan Keuangan', 'harga' => 700000, 'deskripsi' => 'Analisis laporan keuangan perusahaan. Rasio likuiditas, profitabilitas, solvabilitas. Rekomendasi perbaikan.'],
                    ['nama_jasa' => 'Konsultasi Legal Usaha', 'harga' => 850000, 'deskripsi' => 'Konsultasi hukum untuk usaha kecil dan menengah. Termasuk perizinan, kontrak, dan perlindungan hukum.'],
                ],
            ],
            [
                'name' => 'SolusiBisnis',
                'email' => 'solusibisnis@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Business',
                'jasas' => [
                    ['nama_jasa' => 'Pembuatan SOP Perusahaan', 'harga' => 1500000, 'deskripsi' => 'Drafting SOP untuk 5 divisi. Standar operasional jelas, audit-proof, siap implementasi.'],
                    ['nama_jasa' => 'Jasa Akuntansi Bulanan', 'harga' => 800000, 'deskripsi' => 'Pencatatan transaksi, laporan keuangan bulanan, neraca, laba rugi. Siap untuk pajak.'],
                    ['nama_jasa' => 'Konsultasi Branding Bisnis', 'harga' => 1000000, 'deskripsi' => 'Konsultasi branding 2 sesi. Termasuk strategi positioning, tagline, dan panduan visual.'],
                    ['nama_jasa' => 'Pendaftaran Merek & HAKI', 'harga' => 2000000, 'deskripsi' => 'Urus pendaftaran merek dagang dan hak cipta. Dari cek availabilitas hingga sertifikat.'],
                ],
            ],
            [
                'name' => 'LegalMitra',
                'email' => 'legalmitra@gmail.com',
                'vendor_type' => 'umkm',
                'kategori' => 'Business',
                'jasas' => [
                    ['nama_jasa' => 'Drafting Kontrak Bisnis', 'harga' => 1200000, 'deskripsi' => 'Pembuatan kontrak kerjasama, NDA, MoU, dan perjanjian jual-beli. Bahasa Indonesia & Inggris.'],
                    ['nama_jasa' => 'Legal Opinion Perusahaan', 'harga' => 900000, 'deskripsi' => 'Pendapat hukum untuk pengambilan keputusan bisnis. Meliputi analisis risiko dan regulasi.'],
                    ['nama_jasa' => 'Pengurusan SIUP & NIB', 'harga' => 750000, 'deskripsi' => 'Urus perizinan usaha melalui OSS. Cepat, legal, dan terintegrasi.'],
                ],
            ],
        ];

        foreach ($vendors as $vendorData) {
            $vendor = User::updateOrCreate(
                ['email' => $vendorData['email']],
                [
                    'name' => $vendorData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'vendor',
                    'status' => 'active',
                    'vendor_type' => $vendorData['vendor_type'],
                    'email_verified_at' => now(),
                ]
            );

            $this->generateSampleCertificates($vendor, $vendorData['email'], $certDir);

            foreach ($vendorData['jasas'] as $jasaData) {
                $gambarArray = [];
                $seed = Str::slug($jasaData['nama_jasa']);

                for ($i = 1; $i <= 3; $i++) {
                    $filename = time() . '_' . uniqid() . '.jpg';
                    $url = "https://picsum.photos/seed/{$seed}-{$i}/400/300";

                    try {
                        $contents = @file_get_contents($url);
                        if ($contents !== false) {
                            file_put_contents($storagePath . '/' . $filename, $contents);
                            $gambarArray[] = $filename;
                        }
                    } catch (\Exception $e) {
                        // skip
                    }
                }

                Jasa::create([
                    'user_id' => $vendor->id,
                    'nama_jasa' => $jasaData['nama_jasa'],
                    'kategori' => $vendorData['kategori'],
                    'harga' => $jasaData['harga'],
                    'deskripsi' => $jasaData['deskripsi'],
                    'gambar' => $gambarArray,
                ]);
            }
        }
    }

    private function generateSampleCertificates(User $vendor, string $email, string $certDir): void
    {
        $certNames = [
            'bersih@gmail.com' => ['BNSP - Tenaga Kebersihan', 'Sertifikat Kompetensi Cleaning Service'],
            'cleanpro@gmail.com' => ['Sertifikat Pelatihan Kebersihan Profesional'],
            'freshhome@gmail.com' => ['Sertifikat Home Cleaning'],
            'teknisi@gmail.com' => ['BNSP - Teknisi Perbaikan', 'Sertifikat Ahli Instalasi Listrik', 'Sertifikat Servis AC'],
            'fixmaster@gmail.com' => ['Sertifikat Perbaikan Rumah Tangga'],
            'bengkelkita@gmail.com' => ['Sertifikat Bengkel & Renovasi'],
            'kreatif@gmail.com' => ['BNSP - Desain Grafis', 'Sertifikat Fotografi Profesional', 'Sertifikat Animator'],
            'desaingrafis@gmail.com' => ['Sertifikat Desain UI/UX'],
            'fotokeren@gmail.com' => ['Sertifikat Fotografi & Videografi'],
            'konsultan@gmail.com' => ['BNSP - Konsultan Bisnis', 'Sertifikat Akuntansi', 'Sertifikat Legalitas Usaha'],
            'solusibisnis@gmail.com' => ['Sertifikat Manajemen Bisnis'],
            'legalmitra@gmail.com' => ['Sertifikat Hukum & Perizinan'],
        ];

        $certs = $certNames[$email] ?? ['Sertifikat Kompetensi'];

        foreach ($certs as $label) {
            $filename = 'cert_' . $vendor->id . '_' . Str::slug($label) . '_' . time() . '.jpg';
            $path = $certDir . '/' . $filename;

            $img = imagecreatetruecolor(350, 250);
            $bg = imagecolorallocate($img, 255, 255, 255);
            $gold = imagecolorallocate($img, 212, 175, 55);
            $black = imagecolorallocate($img, 0, 0, 0);
            $gray = imagecolorallocate($img, 100, 100, 100);

            imagefill($img, 0, 0, $bg);
            imagerectangle($img, 5, 5, 345, 245, $gold);
            imagerectangle($img, 10, 10, 340, 240, $gold);
            imagestring($img, 4, 30, 30, 'SERTIFIKAT KOMPETENSI', $black);
            imagestring($img, 3, 30, 60, 'Diberikan kepada:', $gray);
            imagestring($img, 5, 30, 85, $vendor->name, $black);
            imagestring($img, 3, 30, 115, $label, $black);
            imagestring($img, 2, 30, 145, 'ServeConnect Certification Board', $gray);

            imagejpeg($img, $path, 85);
            imagedestroy($img);

            VendorCertificate::create([
                'user_id' => $vendor->id,
                'certificate_file' => 'certificates/' . $filename,
                'certificate_name' => $label,
            ]);
        }
    }
}
