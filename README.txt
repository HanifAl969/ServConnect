# 🤖 ServConn Chatbot API — Developer API Implementation

**Test-2 RPL A | Developer API | Rabu 10 Juni 2026**

---

## 📁 File yang Ditambahkan ke Project

```
app/Http/Controllers/Api/ChatbotController.php   ← Implementasi utama
routes/api.php                                    ← API routes
tests/Feature/Api/ChatbotApiTest.php              ← Feature & Security Testing
tests/Unit/PromptInjectionTest.php                ← Unit Testing
SETUP_INSTRUCTIONS.php                            ← Cara setup
```

---

## ⚙️ Setup

### 1. Install Sanctum
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 2. Tambahkan ke `.env`
```
OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### 3. Tambahkan ke `config/services.php`
```php
'openai' => [
    'key' => env('OPENAI_API_KEY'),
],
```

### 4. Update `bootstrap/app.php` — tambahkan `api` route
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',  // tambahkan ini
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

### 5. Tambahkan `HasApiTokens` ke `User` model
```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
```

---

## 🌐 Endpoint API

| Method | URL | Auth | Keterangan |
|--------|-----|------|-----------|
| GET | `/api/chat/health` | ❌ | Cek status API |
| POST | `/api/chat` | ✅ Sanctum | Kirim pesan ke chatbot |

### Request Body (POST /api/chat)
```json
{
  "message": "Saya butuh jasa desain logo"
}
```

### Response Sukses
```json
{
  "success": true,
  "reply": "Kami punya banyak vendor desain grafis yang siap membantu!",
  "usage": {
    "prompt_tokens": 45,
    "completion_tokens": 28
  }
}
```

---

## 🔒 Security Engineering (SSE)

| Aspek | Implementasi |
|-------|-------------|
| **API Key Protection** | Key disimpan di `.env`, tidak di-hardcode |
| **Authentication** | Laravel Sanctum token-based auth |
| **Rate Limiting** | Throttle 20 request/menit per user |
| **Input Validation** | `required`, `string`, `max:1000` |
| **Input Sanitization** | `strip_tags()` — cegah XSS |
| **Prompt Injection** | Regex pattern detection |
| **Output Sanitization** | `htmlspecialchars()` pada response OpenAI |
| **Error Handling** | Pesan error generik ke client, detail di log |
| **Logging** | Aktivitas dicatat tanpa data sensitif |

---

## 🧪 Menjalankan Test

```bash
# Semua test
php artisan test

# Hanya chatbot tests
php artisan test tests/Feature/Api/ChatbotApiTest.php
php artisan test tests/Unit/PromptInjectionTest.php

# Dengan detail
php artisan test --verbose
```

### Test Coverage

**Feature Tests (ChatbotApiTest.php):**
- ✅ Health endpoint returns OK
- ✅ Authenticated user dapat kirim pesan
- ✅ Response sesuai dari OpenAI
- ✅ Handles OpenAI service down (503)
- ✅ Unauthenticated user ditolak (401)
- ✅ Pesan kosong ditolak (422)
- ✅ Pesan terlalu panjang ditolak (422)
- ✅ Field message wajib ada (422)
- ✅ Prompt injection diblokir (422)
- ✅ HTML tags di-strip dari input
- ✅ Rate limiting aktif (429)

**Unit Tests (PromptInjectionTest.php):**
- ✅ Deteksi "ignore previous instructions"
- ✅ Deteksi "system: override"
- ✅ Deteksi special LLM tokens
- ✅ Pesan normal lolos
- ✅ Pertanyaan Indonesia lolos
- ✅ Pesan Inggris normal lolos

---

## 📋 Mapping CPL

| CPL | Aspek | Implementasi |
|-----|-------|-------------|
| **CPL-2** | Requirement Quality | Validasi input sesuai kebutuhan bisnis |
| **CPL-5** | Security Requirement | Auth, rate limit, sanitasi, injection protection |
| **CPL-10** | Implementasi | ChatbotController + OpenAI integration |
| **CPL-13** | Testing | 11 Feature test + 6 Unit test |
