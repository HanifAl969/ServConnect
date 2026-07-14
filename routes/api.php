<?php

use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - ServConn Chatbot
|--------------------------------------------------------------------------
|
| SECURITY LAYERS:
| 1. auth:sanctum  → hanya user yang login bisa akses
| 2. throttle:20,1 → max 20 request per menit per user (rate limiting)
|
*/

// Health check - public (tidak perlu login)
Route::get('/chat/health', [ChatbotController::class, 'health']);

// Chatbot public - tanpa auth, rate limit 10 req/menit per IP
Route::post('/chat/public', [ChatbotController::class, 'chatPublic'])
    ->middleware('throttle:10,1');

// Chatbot endpoint - protected (login required)
Route::middleware(['auth:sanctum', 'throttle:20,1'])->group(function () {
    Route::post('/chat', [ChatbotController::class, 'chat']);
});
