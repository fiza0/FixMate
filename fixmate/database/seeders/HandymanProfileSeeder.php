<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HandymanProfile;

class HandymanProfileSeeder extends Seeder
{
    public function run(): void
    {
        $handyman1 = User::where('email', 'john@fixmate.com')->first();
        $handyman2 = User::where('email', 'peter@fixmate.com')->first();

        HandymanProfile::create([
            'user_id' => $handyman1->id,
            'skill_category' => 'electrician',
            'bio' => 'Experienced electrician specializing in home installations and repairs.',
            'min_rate' => 1500.00,
            'max_rate' => 4000.00,
            'average_rating' => 4.7,
            'location' => 'Nairobi',
        ]);

        HandymanProfile::create([
            'user_id' => $handyman2->id,
            'skill_category' => 'plumber',
            'bio' => 'Certified plumber with 5 years of experience in residential maintenance.',
            'min_rate' => 1200.00,
            'max_rate' => 3500.00,
            'average_rating' => 4.5,
            'location' => 'Nairobi',
        ]);
    }
}

