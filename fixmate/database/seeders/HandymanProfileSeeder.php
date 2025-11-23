<?php

namespace Database\Seeders;
use App\Models\HandymanProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HandymanProfileSeeder extends Seeder
{
    public function run(): void
    {
        $skills = ['plumber', 'electrician', 'carpenter', 'mechanic', 'painter', 'general'];

        $handymen = User::where('role', 'handyman')->get();

        foreach ($handymen as $handyman) {
            HandymanProfile::create([
                'user_id' => $handyman->id,
                'skill_category' => collect($skills)->random(),
                'bio' => 'Experienced professional available for your tasks.',
                'min_rate' => 1500,
                'max_rate' => 5000,
                'average_rating' => 0,
                'location' => fake()->city(),
            ]);
        }
    }
}

