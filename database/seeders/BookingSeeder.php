<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\Jasa;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@gmail.com')->first();
        if (!$user) return;

        // 10 booking across all status variants
        $bookingsConfig = [
            // [vendor_email, status, create_payment, payment_status]
            ['bersih@gmail.com', 'pending', false, null],
            ['bersih@gmail.com', 'accepted', false, null],
            ['bersih@gmail.com', 'accepted', true, 'pending'],
            ['bersih@gmail.com', 'completed', true, 'success'],

            ['fixmaster@gmail.com', 'pending', false, null],
            ['fixmaster@gmail.com', 'accepted', false, null],
            ['fixmaster@gmail.com', 'completed', true, 'success'],

            ['desaingrafis@gmail.com', 'accepted', true, 'pending'],

            ['konsultan@gmail.com', 'cancelled', false, null],
            ['konsultan@gmail.com', 'completed', true, 'success'],
        ];

        $createdBookings = [];

        foreach ($bookingsConfig as $config) {
            [$email, $status, $createPayment, $paymentStatus] = $config;

            $vendor = User::where('email', $email)->first();
            if (!$vendor) continue;

            $jasaIds = Jasa::where('user_id', $vendor->id)->pluck('id');
            if ($jasaIds->isEmpty()) continue;

            $daysAgo = rand(3, 14);

            $booking = Booking::create([
                'user_id' => $user->id,
                'jasa_id' => $jasaIds->random(),
                'vendor_id' => $vendor->id,
                'status' => $status,
                'booking_date' => now()->subDays($daysAgo),
                'phone' => '08123456789',
                'address' => 'Jl. Contoh No. 123, Kelurahan Sukamaju, Kecamatan Sukabumi, Kota Contoh 12345',
                'preferred_time' => ['pagi', 'siang', 'sore'][rand(0, 2)],
                'notes' => $status === 'cancelled' ? 'Maaf, booking dibatalkan.' : null,
            ]);

            $createdBookings[] = ['booking' => $booking, 'vendor' => $vendor, 'status' => $status];

            if ($createPayment) {
                $paidAt = $paymentStatus === 'success' ? now()->subHours(rand(2, 36)) : null;

                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $booking->jasa->harga,
                    'status' => $paymentStatus,
                    'payment_method' => 'transfer',
                    'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                    'payment_proof' => null,
                    'paid_at' => $paidAt,
                    'confirmed_at' => $paidAt ? $paidAt->copy()->addHours(rand(1, 12)) : null,
                ]);
            }
        }

        // --- SEED CHAT MESSAGES ---
        $chatPath = public_path('storage/chat');
        if (!is_dir($chatPath)) {
            mkdir($chatPath, 0755, true);
        }

        foreach ($createdBookings as $item) {
            $booking = $item['booking'];
            $vendor = $item['vendor'];
            $status = $item['status'];

            // Only seed chat for accepted/completed bookings
            if (!in_array($status, ['accepted', 'completed'])) continue;

            $messages = match ($vendor->email) {
                'bersih@gmail.com' => [
                    ['sender' => $user, 'message' => 'Halo kak, mau tanya dong. Lokasi tempatnya di Jl. Contoh itu gampang dicari nggak? Saya khawatir tukang servisnya nyasar.'],
                    ['sender' => $vendor, 'message' => 'Halo kak, insyaAllah gampang kok. Nanti kakak bisa kirim foto lokasi biar lebih jelas.'],
                    ['sender' => $user, 'message' => 'Baik kak, ini foto lokasi rumah saya. Pintu pagar hitam, ada pohon mangga besar di depan.'],
                    ['sender' => $user, 'photo' => 'chat/sample-location.jpg'],
                    ['sender' => $vendor, 'message' => 'Oke kak, jelas banget. Nanti saya cari lokasi lewat Google Maps. Kurang lebih jam 10 pagi sampai.'],
                    ['sender' => $user, 'message' => 'Siap kak, terima kasih!'],
                ],
                'fixmaster@gmail.com' => [
                    ['sender' => $user, 'message' => 'Permisi kak, mau tanya untuk servis AC, apakah teknisi bawa tangga sendiri?'],
                    ['sender' => $vendor, 'message' => 'Tentu kak, kami bawa perlengkapan lengkap kok. Tinggal siapkan area aja.'],
                    ['sender' => $user, 'message' => 'Baik kak, kalau gitu besok saya tunggu ya. Mohon konfirmasi jam kedatangan.'],
                ],
                'desaingrafis@gmail.com' => [
                    ['sender' => $vendor, 'message' => 'Halo kak, untuk desain feed Instagram-nya, ada referensi gaya yang diinginkan?'],
                    ['sender' => $user, 'message' => 'Halo kak, saya mau yang minimalis aja, warna biru navy seperti logo brand saya.'],
                    ['sender' => $vendor, 'message' => 'Siap kak, nanti saya buatkan 3 opsi dulu ya.'],
                ],
                'konsultan@gmail.com' => [
                    ['sender' => $user, 'message' => 'Terima kasih banyak atas konsultasinya tadi kak, sangat membantu!'],
                    ['sender' => $vendor, 'message' => 'Sama-sama kak, senang bisa bantu. Nanti kalau ada keperluan lain, hubungi lagi ya.'],
                ],
                default => [],
            };

            foreach ($messages as $i => $msg) {
                $chatData = [
                    'booking_id' => $booking->id,
                    'sender_id' => $msg['sender']->id,
                    'message' => $msg['message'] ?? null,
                    'created_at' => now()->subHours(count($messages) - $i)->subMinutes(rand(1, 10)),
                    'updated_at' => now()->subHours(count($messages) - $i)->subMinutes(rand(1, 10)),
                ];

                if (isset($msg['photo'])) {
                    $chatData['photo'] = $msg['photo'];
                }

                ChatMessage::create($chatData);
            }
        }
    }
}
