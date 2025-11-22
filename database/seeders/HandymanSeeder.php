<?php

namespace Database\Seeders;

use App\Models\Handyman;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HandymanSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();

        // Create 50 handymen
        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'name' => fake()->name,
                'email' => "handyman{$i}@example.com",
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber,
                'role' => 'handyman',
                'email_verified_at' => now(),
            ]);

            $handyman = Handyman::factory()->create([
                'user_id' => $user->id,
            ]);

            // Attach 1-4 random services
            $randomServices = $services->random(rand(1, 4));
            foreach ($randomServices as $index => $service) {
                $handyman->services()->attach($service->id, [
                    'is_primary' => $index === 0, // First service is primary
                    'experience_years' => rand(1, 15),
                ]);
            }

            // Create availability windows (Mon-Fri)
            for ($day = 1; $day <= 5; $day++) {
                $handyman->availabilityWindows()->create([
                    'day_of_week' => $day,
                    'start_time' => '08:00:00',
                    'end_time' => '18:00:00',
                    'is_active' => true,
                ]);
            }

            // Some handymen also work weekends
            if (rand(1, 10) > 7) {
                $handyman->availabilityWindows()->create([
                    'day_of_week' => 6, // Saturday
                    'start_time' => '09:00:00',
                    'end_time' => '15:00:00',
                    'is_active' => true,
                ]);
            }
        }
    }
}

