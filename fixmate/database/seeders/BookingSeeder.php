<?php

namespace Database\Seeders;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $homeowners = User::where('role', 'homeowner')->get();
        $handymen   = User::where('role', 'handyman')->get();

        foreach ($homeowners as $homeowner) {
            Booking::factory(2)->create([
                'homeowner_id' => $homeowner->id,
                'handyman_id' => $handymen->random()->id,
            ]);
        }
    }
}
