<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('vendor_id');
            $table->text('address')->nullable()->after('phone');
            $table->string('preferred_time', 10)->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'preferred_time']);
        });
    }
};
