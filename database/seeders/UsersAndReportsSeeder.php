<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersAndReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users
        $users = [];
        
        $userData = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com'],
            ['name' => 'Sarah Williams', 'email' => 'sarah@example.com'],
            ['name' => 'David Brown', 'email' => 'david@example.com'],
            ['name' => 'Emily Davis', 'email' => 'emily@example.com'],
            ['name' => 'Robert Miller', 'email' => 'robert@example.com'],
            ['name' => 'Lisa Anderson', 'email' => 'lisa@example.com'],
        ];

        foreach ($userData as $data) {
            $users[] = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_admin' => false,
                ]
            );
        }

        $this->command->info('Created ' . count($users) . ' users');

        // Get zones from config
        $zones = array_keys(config('routes.surigao_city', []));
        
        // Sample report descriptions
        $reportDescriptions = [
            'Large pile of garbage bags left on the sidewalk. Needs immediate attention.',
            'Dumped furniture blocking the street. Please remove as soon as possible.',
            'Overflowing trash bin in the park area. Very smelly and attracting pests.',
            'Construction debris left on the road. Creating traffic hazard.',
            'Illegal dumping site behind the building. Needs cleanup.',
            'Broken glass and sharp objects in the garbage area. Safety concern.',
            'Garbage truck missed our area today. Collection needed.',
            'Burning trash in the neighborhood. Fire hazard and air pollution.',
            'Abandoned vehicle with trash inside. Needs removal.',
            'Sewage leak near garbage collection point. Health risk.',
            'Plastic waste scattered by the wind. Environmental concern.',
            'Dead animals in the trash. Needs proper disposal.',
            'Hazardous materials mixed with regular trash. Dangerous.',
            'Garbage blocking drainage system. Flood risk during rain.',
            'Uncollected waste for 3 days. Service disruption.',
        ];

        // Create community reports
        $reportsCreated = 0;
        $statuses = ['pending', 'pending', 'pending', 'resolved', 'rejected']; // More pending for testing
        
        foreach ($users as $user) {
            // Each user creates 2-3 reports
            $numReports = rand(2, 3);
            
            for ($i = 0; $i < $numReports; $i++) {
                $location = $zones[array_rand($zones)] ?? 'Zone 1';
                $description = $reportDescriptions[array_rand($reportDescriptions)];
                $status = $statuses[array_rand($statuses)];
                
                Report::create([
                    'user_id' => $user->id,
                    'location' => $location,
                    'description' => $description,
                    'status' => $status,
                    'priority' => ['low', 'medium', 'high', 'critical'][rand(0, 3)],
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
                
                $reportsCreated++;
            }
        }

        $this->command->info("Created {$reportsCreated} community reports");
        $this->command->info("\nLogin credentials for testing:");
        $this->command->info("Email: john@example.com");
        $this->command->info("Password: password");
        $this->command->info("\nAll users have password: password");
    }
}
