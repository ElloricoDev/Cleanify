<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users and community reports
        $this->call(UsersAndReportsSeeder::class);

        // Seed reports if users exist (if ReportSeeder exists)
        if (class_exists(ReportSeeder::class)) {
            $this->call(ReportSeeder::class);
        }
        
        // Seed schedules (if ScheduleSeeder exists)
        if (class_exists(ScheduleSeeder::class)) {
            $this->call(ScheduleSeeder::class);
        }
        
        // Seed trucks (if TruckSeeder exists)
        if (class_exists(TruckSeeder::class)) {
            $this->call(TruckSeeder::class);
        }
    }
}
