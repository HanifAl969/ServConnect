<?php
$_SERVER['APP_ENV'] = 'testing';
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$vendor = App\Models\User::where('email', 'vendor@gmail.com')->first();
echo "Vendor: $vendor->name, role=$vendor->role, status=$vendor->status\n";

$booking = App\Models\Booking::create([
    'user_id' => 2,
    'jasa_id' => 1,
    'vendor_id' => $vendor->id,
    'status' => 'pending',
    'booking_date' => now()->addDay(),
    'phone' => '08123456789',
    'address' => 'Test address',
    'notes' => 'Test'
]);
echo "Created booking #$booking->id status=$booking->status\n";

try {
    $booking->update(['status' => 'accepted']);
    echo "Update OK\n";
} catch (Exception $e) {
    echo "Update FAIL: " . $e->getMessage() . "\n";
}

try {
    $booking->user->notify(new App\Notifications\BookingStatusChanged($booking));
    echo "Notify OK\n";
} catch (Exception $e) {
    echo "Notify FAIL: " . $e->getMessage() . "\n";
}

$booking->delete();
echo "Done\n";
