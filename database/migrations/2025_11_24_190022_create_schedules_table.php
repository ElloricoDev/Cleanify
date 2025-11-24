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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('area'); // Barangay / Zone
            $table->string('days'); // Collection days (e.g., "Monday & Thursday")
            $table->time('time_start'); // Start time
            $table->time('time_end'); // End time
            $table->string('truck'); // Truck assigned
            $table->enum('status', ['active', 'pending', 'inactive'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
