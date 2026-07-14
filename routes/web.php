<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Admin\UserController; 
use Illuminate\Support\Facades\Route;
use App\Models\Jasa;
use App\Models\User;

// --- ABOUT ---
Route::view('/about', 'about')->name('about');

// --- DETAIL JASA (US1) ---
Route::get('/jasa/{jasa}', [JasaController::class, 'show'])->name('jasa.show');

// --- HALAMAN DEPAN (US1) ---
Route::get('/', function () {
    $query = Jasa::with('user');

    if ($search = request('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_jasa', 'like', "%{$search}%")
              ->orWhere('kategori', 'like', "%{$search}%")
              ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    if ($kategori = request('kategori')) {
        $query->where('kategori', $kategori);
    }

    $jasas = $query->latest()->get();
    $jasasByCategory = $jasas->groupBy('kategori');
    $kategoriCounts = Jasa::selectRaw('kategori, count(*) as total')
        ->groupBy('kategori')->pluck('total', 'kategori');
    $vendors = User::where('role', 'vendor')->where('status', 'active')->count();
    return view('welcome', compact('jasasByCategory', 'kategoriCounts', 'vendors'));
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

    // --- BOOKING (US6) ---
    Route::get('/booking/create/{jasa}/{vendor?}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    // --- NOTIFICATIONS (US8) ---
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');

    // --- PAYMENT (US7) ---
    Route::get('/payment/create/{booking}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payments.store');

    // --- CHAT ---
    Route::get('/booking/{booking}/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/booking/{booking}/chat/messages', [ChatController::class, 'messages'])->name('chat.messages');
    Route::post('/booking/{booking}/chat', [ChatController::class, 'store'])->name('chat.store');

    // --- KHUSUS ADMIN (US3, US5 & US9) ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/admin/vendor-verification', [UserController::class, 'vendorVerification'])->name('admin.vendor.verification');
        Route::patch('/admin/vendor/{user}/approve', [UserController::class, 'approveVendor'])->name('admin.vendor.approve');
        Route::patch('/admin/vendor/{user}/reject', [UserController::class, 'rejectVendor'])->name('admin.vendor.reject');

        Route::get('/admin/user-verification', [UserController::class, 'userVerification'])->name('admin.user.verification');
        Route::patch('/admin/user/{user}/approve', [UserController::class, 'approveUser'])->name('admin.user.approve');
        Route::patch('/admin/user/{user}/reject', [UserController::class, 'rejectUser'])->name('admin.user.reject');

        Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings');
    });

    // --- KHUSUS VENDOR (US2, US4 & US6) ---
    Route::middleware('role:vendor')->group(function () {
        Route::get('/vendor/jasa/create', [JasaController::class, 'create'])->name('vendor.jasa.create');
        Route::post('/vendor/jasa/store', [JasaController::class, 'store'])->name('vendor.jasa.store');
        Route::get('/vendor/jasa/{jasa}/edit', [JasaController::class, 'edit'])->name('vendor.jasa.edit');
        Route::put('/vendor/jasa/{jasa}', [JasaController::class, 'update'])->name('vendor.jasa.update');
        Route::delete('/vendor/jasa/{jasa}', [JasaController::class, 'destroy'])->name('vendor.jasa.destroy');

        Route::get('/vendor/bookings', [BookingController::class, 'vendorIndex'])->name('vendor.bookings');
        Route::patch('/vendor/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('vendor.bookings.update-status');
        Route::post('/vendor/bookings/{booking}/confirm-payment', [BookingController::class, 'confirmPayment'])->name('vendor.bookings.confirm-payment');

        Route::get('/vendor/chat', function () {
            return view('vendor.chat');
        })->name('vendor.chat');

        Route::get('/vendor/talent', [VendorController::class, 'talent'])->name('vendor.talent');
        Route::post('/vendor/certificate/upload', [VendorController::class, 'uploadCertificate'])->name('vendor.certificate.upload');
        Route::delete('/vendor/certificate/{certificate}', [VendorController::class, 'deleteCertificate'])->name('vendor.certificate.delete');
    });

});

require __DIR__.'/auth.php';