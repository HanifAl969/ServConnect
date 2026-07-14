<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\Admin\UserController; 
use Illuminate\Support\Facades\Route;
use App\Models\Jasa;
use App\Models\User;

// --- HALAMAN DEPAN (US1) ---
Route::get('/', function () {
    $jasas = Jasa::with('user')->latest()->take(8)->get();
    return view('welcome', compact('jasas'));
});

// --- DASHBOARD ROUTER (Pusat Kendali US2 & US3) ---
// Kita pastikan dashboard melempar data yang dibutuhkan view baru lo
Route::get('/dashboard', function() {
    $user = auth()->user();

    if ($user->role === 'admin') {
        // Ambil data user untuk tabel di dashboard admin (US3)
        $users = User::latest()->paginate(5);
        return view('admin.dashboard', compact('users'));
    } 

    if ($user->role === 'vendor') {
        // Ambil data jasa milik vendor ini saja (US2)
        $jasas = Jasa::where('user_id', $user->id)->latest()->get();
        return view('vendor.dashboard', compact('jasas'));
    }

    // Default untuk user biasa (bisa lo arahin ke landing page atau dashboard member)
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP MIDDLEWARE AUTH ---
Route::middleware('auth')->group(function () {
    
    // Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- KHUSUS ADMIN (US3 & US5) ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // --- KHUSUS VENDOR (US2 & US4) ---
    Route::middleware('role:vendor')->group(function () {
        // Pastikan JasaController@create mengarah ke file yang benar (vendor/jasa/create.blade.php)
        Route::get('/vendor/jasa/create', [JasaController::class, 'create'])->name('vendor.jasa.create');
        Route::post('/vendor/jasa/store', [JasaController::class, 'store'])->name('vendor.jasa.store');
    });

});

require __DIR__.'/auth.php';