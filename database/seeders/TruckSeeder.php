<?php

namespace Database\Seeders;

use App\Models\Truck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trucks = [
            [
                'code' => 'TRK-001',
                'driver' => 'Juan Dela Cruz',
                'route' => 'Zone 1 - Barangay Washington',
                'status' => 'active',
                'latitude' => 9.7870,
                'longitude' => 125.4928,
                'last_updated' => now()->subMinutes(5),
            ],
            [
                'code' => 'TRK-002',
                'driver' => 'Maria Santos',
                'route' => 'Zone 2 - Barangay Taft',
                'status' => 'on_break',
                'latitude' => 9.7890,
                'longitude' => 125.4950,
                'last_updated' => now()->subMinutes(20),
            ],
            [
                'code' => 'TRK-003',
                'driver' => 'Pedro Ramos',
                'route' => 'Zone 3 - Barangay Canlanipa',
                'status' => 'offline',
                'latitude' => null,
                'longitude' => null,
                'last_updated' => now()->subHour(),
            ],
        ];

        foreach ($trucks as $truck) {
            Truck::create($truck);
        }

        $this->command->info('Created ' . count($trucks) . ' sample trucks.');
    }
}
