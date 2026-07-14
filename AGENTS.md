# ServConn Chatbot API — AGENTS.md

## Setup

```bash
composer install
cp .env.example .env          # lalu isi OPENAI_API_KEY
php artisan key:generate
php artisan migrate --force
php artisan db:seed
```

Atau: `composer run setup` (jalanin semua termasuk `npm install && npm run build`)

**.env.example tidak punya OPENAI_API_KEY** — tambahkan manual:
```
OPENAI_API_KEY=sk-...
```

## Menjalankan

```bash
php artisan serve --port=8000          # server aja
composer run dev                        # server + queue + logs + Vite via concurrently
npm run dev                             # Vite/HMR frontend aja
```

## Testing

- Framework: **Pest PHP** (`tests/Feature/*.php`, `tests/Unit/*.php`)
- `composer test` → `config:clear` dulu baru `php artisan test`
- Single file: `php artisan test tests/Feature/Api/ChatbotApiTest.php`
- **`phpunit.xml` override `DB_CONNECTION=mysql`** — lingkungan tanpa MySQL akan gagal. Ganti ke `sqlite` atau `:memory:` secara lokal.
- Rate limit test bisa flaky: perlu `RateLimiter::clear()` sebelum loop.

## Arsitektur

- **Laravel 11**, DB: SQLite (dev), Sanctum auth
- 3 role: `admin` | `vendor` | `user` — dicek via middleware `role:...` (alias di `bootstrap/app.php`)
- **Chatbot** → `app/Http/Controllers/Api/ChatbotController.php` → OpenAI `gpt-3.5-turbo`
- **Tidak ada ChatLog model** — setiap chat stateless, history tidak disimpan
- **System prompt hardcoded** di controller — ubah di `chat()` L62-66
- **Sanctum token never expire** (`config/sanctum.php` → `'expiration' => null`)

## Endpoints

| Method | URI | Auth |
|--------|-----|------|
| GET | `/api/chat/health` | Public |
| POST | `/api/chat` | Sanctum + throttle:20,1 |

## Known Bugs

- ~~`app/Models/Jasa.php` **missing `gambar` di `$fillable`** — gambar tidak tersimpan saat vendor create jasa. Migration & controller sudah punya kolom `gambar`, tapi model menolaknya.~~ ✅ Fixed
- `routes/web.php` closure `/dashboard` duplikasi logic dengan `DashboardController::index()`

## Security (existing, jangan dihapus)

- Input: `strip_tags()` + `max:1000` + regex injection detection
- Output: `htmlspecialchars()` on reply
- Rate limit: 20/min/user (`throttle:20,1`)
- API key via `config('services.openai.key')` — jangan hardcode
- Logging tanpa data sensitif
- Prompt injection test via `ReflectionMethod` akses private method

## Akun Seeder

| Email | Password | Role |
|-------|----------|------|
| admin@gmail.com | password | admin |
| vendor@gmail.com | password | vendor |
| user@gmail.com | password | user |
