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
            $table->integer('tracker_refresh_interval')->default(30)->after('profile_visibility'); // in seconds
            $table->string('language')->default('en')->after('tracker_refresh_interval');
            $table->timestamp('last_login_at')->nullable()->after('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tracker_refresh_interval', 'language', 'last_login_at']);
        });
    }
};
