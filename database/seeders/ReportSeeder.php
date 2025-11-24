<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get non-admin users
        $users = User::where('is_admin', false)->get();

        if ($users->isEmpty()) {
            $this->command->warn('No regular users found. Please create users first.');
            return;
        }

        $reports = [
            [
                'location' => 'Barangay Lakandula',
                'description' => 'Uncollected garbage near basketball court. The trash has been piling up for days and is starting to smell.',
                'status' => 'pending',
            ],
            [
                'location' => 'Purok 3',
                'description' => 'Overflowing trash bins beside market area. The bins are full and garbage is spilling onto the street.',
                'status' => 'resolved',
                'admin_notes' => 'Garbage collection completed. Area cleaned and bins emptied.',
            ],
            [
                'location' => 'Zone 5',
                'description' => 'Dump site blocking the road. Large pile of garbage is obstructing traffic.',
                'status' => 'rejected',
                'rejection_reason' => 'This location is not within our service area. Please contact the appropriate barangay office.',
            ],
            [
                'location' => 'Near Barangay Hall',
                'description' => 'Illegal dumping near the school entrance. It\'s starting to smell and attract insects.',
                'status' => 'pending',
            ],
            [
                'location' => 'Zone 3, Riverside',
                'description' => 'Large amount of plastic waste washed up on the riverbank. Needs immediate attention.',
                'status' => 'resolved',
                'admin_notes' => 'Cleanup team dispatched. All waste collected and properly disposed.',
            ],
            [
                'location' => 'Market Area',
                'description' => 'Food waste left on the sidewalk. Creating health hazard and attracting pests.',
                'status' => 'pending',
            ],
            [
                'location' => 'Residential Area - Block 2',
                'description' => 'Neighbors dumping garbage in vacant lot. This is becoming a recurring problem.',
                'status' => 'rejected',
                'rejection_reason' => 'This requires community intervention. Please report to barangay officials for proper action.',
            ],
            [
                'location' => 'Main Street',
                'description' => 'Construction debris left on the side of the road. Needs to be removed.',
                'status' => 'resolved',
                'admin_notes' => 'Coordinated with construction company. Debris removed.',
            ],
        ];

        foreach ($reports as $index => $reportData) {
            $user = $users->random();
            $admin = User::where('is_admin', true)->first();

            $report = Report::create([
                'user_id' => $user->id,
                'location' => $reportData['location'],
                'description' => $reportData['description'],
                'image_path' => null, // Can be updated later with actual images
                'status' => $reportData['status'],
                'admin_notes' => $reportData['admin_notes'] ?? null,
                'rejection_reason' => $reportData['rejection_reason'] ?? null,
                'resolved_by' => ($reportData['status'] !== 'pending' && $admin) ? $admin->id : null,
                'resolved_at' => ($reportData['status'] !== 'pending') ? now()->subDays(rand(1, 10)) : null,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);
        }

        $this->command->info('Created ' . count($reports) . ' sample reports.');
    }
}
