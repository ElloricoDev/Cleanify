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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('show_email')->default(false)->after('notification_preferences');
            $table->boolean('location_sharing')->default(true)->after('show_email');
            $table->string('profile_visibility')->default('public')->after('location_sharing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['show_email', 'location_sharing', 'profile_visibility']);
        });
    }
};
