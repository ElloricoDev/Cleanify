<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Truck ID (e.g., TRK-001)
            $table->string('driver'); // Driver name
            $table->string('route'); // Route description
            $table->enum('status', ['active', 'on_break', 'offline', 'maintenance'])->default('offline');
            $table->decimal('latitude', 10, 8)->nullable(); // GPS latitude
            $table->decimal('longitude', 11, 8)->nullable(); // GPS longitude
            $table->timestamp('last_updated')->nullable(); // Last location update
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
