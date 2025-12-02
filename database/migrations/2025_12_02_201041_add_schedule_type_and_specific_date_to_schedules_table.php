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
        Schema::table('schedules', function (Blueprint $table) {
            $table->enum('schedule_type', ['recurring', 'specific_date'])->default('recurring')->after('area');
            $table->date('specific_date')->nullable()->after('schedule_type');
            // Make days nullable since specific_date schedules don't need days
            $table->string('days')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['schedule_type', 'specific_date']);
            // Revert days to required
            $table->string('days')->nullable(false)->change();
        });
    }
};
