# ServConn — AGENTS.md

## Setup & Dev
```bash
composer run setup       # install + .env + key + migrate + npm
composer run dev         # server:8000 + queue + logs + Vite (concurrently)
php artisan serve --port=8000
```
`storage:link` wajib setelah `migrate —seed` (foto jasa/booking/payment/chat).

## Testing
- `composer test` → `config:clear` lalu `php artisan test`
- Single: `php artisan test tests/Feature/Api/ChatbotApiTest.php`
- SQLite `:memory:` (phpunit.xml) — aman tanpa MySQL
- Rate limit test: `RateLimiter::clear()` before loop (flaky)

## DB & Migrations
- SQLite **tidak bisa** `add_column NOT NULL` tanpa default — kolom baru harus `->nullable()`
- `vendor_type` disimpan sebagai `string`, divalidasi di controller (`umkm`/`enterprise`)

## Architecture
- Laravel 11, SQLite (dev), Sanctum auth (token never expire)
- 3 role: `admin | vendor | user` — middleware `role:...` alias di `bootstrap/app.php`
- `layouts.app` (Breeze default) **tidak dipakai**
- `@stack('scripts')` hanya ada di `layouts.user` — vendor/admin layout **tidak** punya

### Layout per Role
| Role | Layout | 
|------|--------|
| Admin | `layouts.admin` — sidebar, `@section('header')` |
| Vendor | `layouts.vendor` — sidebar, `@section('header')` |
| User | `layouts.user` — navbar |

Shared views pakai conditional:
```php
@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.user'))
```

## Registration & Verification
- **User**: wajib upload KTP (`ktp_photo`), `status=pending`, redirect + flash
- **Vendor**: wajib pilih `vendor_type` (`umkm`/`enterprise`) + upload ≥1 sertifikat, `status=pending`
- **Admin approve**: `/admin/vendor-verification` (vendor) dan `/admin/user-verification` (user KTP)
- **RoleManager** blokir pending/rejected dari akses role-specific routes
- **BookingController** cek `Auth::user()->status === 'active'` di create/store

## Jasa
- `gambar[]` array JSON, min 3 foto JPG/PNG max 5MB
- `'gambar' => 'array'` cast di model
- `views` (integer default 0) di-increment tiap `JasaController@show`
- Tampilkan pertama: `$jasa->gambar[0] ?? null`

## Booking
- Route `/{jasa}/{vendor?}` → `vendor_id` dari form, **bukan** `$jasa->user_id`
- Validasi `BookingRequest`: `phone` (regex `^08[0-9]{8,13}$`), `address` (min:10), `photos` (required array min:3), `booking_date` (after_or_equal:today), `preferred_time` (in:pagi,siang,sore), `notes` (max:500)
- Foto di `storage/app/public/bookings/`, path JSON di kolom `photos`

## Chat
- Tabel `chat_messages`: `booking_id`, `sender_id`, `message` (nullable), `photo` (nullable)
- Aktif untuk `accepted` / `completed` / `cancelled` (read-only)
- Guard: hanya `user_id` atau `vendor_id` yang punya booking
- Frontend polling 3 detik via `setInterval`, kirim text + foto, auto-scroll
- Foto di `storage/app/public/chat/`

## Payment (Transfer Manual)
1. User upload bukti → `POST /payment` → status=`pending`, booking tetap `accepted`
2. Vendor konfirmasi → `POST /vendor/bookings/{booking}/confirm-payment` → payment=`success`, booking=`completed`
3. Norek dari `config/payment.php` (env: `BANK_NAME`, `BANK_ACCOUNT`, `BANK_HOLDER`)
4. Bukti di `storage/app/public/payments/`

## Agent Cards (jasa/show)
- Grid semua vendor di kategori sama, tiap card: 2 jasa (truncate + `line-clamp-2`)
- Badges: **Perusahaan Terpercaya** (enterprise, hijau+verified), **UMKM** (biru), **Professional** (jasas≥5), **Populer** (accepted+completed >10)
- Foto: `i.pravatar.cc/200?u={email}`

## Vendor Dashboard
- 6 stat cards: Jasa Aktif, Booking Masuk (pending), Diterima (accepted), Selesai (completed), Pemasukan (completed+payment success revenue), Dilihat (sum views)
- Tabel Jasa Saya: kolom Harga, Pendapatan (`completed_count × harga`), Dilihat (`$jasa->views`)

## Rupiah Format
`Rp {{ number_format($harga, 0, ',', '.') }}`

## Known Bug
- `routes/web.php` closure `/dashboard` duplikasi logic dengan `JasaController::index()`

## API Chatbot (jangan dihapus)
- `POST /api/chat` — input `strip_tags()` + `max:1000` + regex injection detection
- Output: `htmlspecialchars()`; API key via `config('services.openai.key')`
- Rate limit: 20 req/menit/user (`throttle:20,1`)
- Prompt injection test akses private method via `ReflectionMethod`

## Akun Seeder (password: `password`)
| Email | Role | Vendor Type |
|-------|------|-------------|
| admin@gmail.com | admin | - |
| user@gmail.com | user | - (status=active, seeded KTP) |
| vendor@gmail.com | vendor | UMKM |
| bersih@gmail.com | vendor | Enterprise |
| bersih@gmail.com | vendor | Enterprise |
| teknisi@gmail.com | vendor | Enterprise |
| kreatif@gmail.com | vendor | Enterprise |
| konsultan@gmail.com | vendor | Enterprise |
