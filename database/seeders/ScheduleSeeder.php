<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'area' => 'Zone 1 - Barangay Washington',
                'days' => 'Monday & Thursday',
                'time_start' => '06:00:00',
                'time_end' => '09:00:00',
                'truck' => 'Truck 01',
                'status' => 'active',
            ],
            [
                'area' => 'Zone 2 - Barangay Taft',
                'days' => 'Tuesday & Friday',
                'time_start' => '07:00:00',
                'time_end' => '10:00:00',
                'truck' => 'Truck 02',
                'status' => 'active',
            ],
            [
                'area' => 'Zone 3 - Barangay Canlanipa',
                'days' => 'Wednesday',
                'time_start' => '08:00:00',
                'time_end' => '11:00:00',
                'truck' => 'Truck 03',
                'status' => 'pending',
            ],
            [
                'area' => 'Zone 4 - Barangay Rizal',
                'days' => 'Saturday',
                'time_start' => '06:30:00',
                'time_end' => '09:30:00',
                'truck' => 'Truck 04',
                'status' => 'active',
            ],
            [
                'area' => 'Zone 5 - Barangay San Juan',
                'days' => 'Sunday',
                'time_start' => '07:00:00',
                'time_end' => '10:00:00',
                'truck' => 'Truck 05',
                'status' => 'inactive',
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }

        $this->command->info('Created ' . count($schedules) . ' sample schedules.');
    }
}
