<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $homeowner = User::where('email', 'jane@fixmate.com')->first();
        $handyman = User::where('email', 'john@fixmate.com')->first();

        Booking::create([
            'homeowner_id' => $homeowner->id,
            'handyman_id' => $handyman->id,
            'service_type' => 'Electrical Repair',
            'description' => 'Kitchen lights not working, possible wiring issue.',
            'scheduled_at' => Carbon::now()->addDays(2),
            'status' => 'requested',
            'estimated_cost' => 2500.00,
        ]);

        Booking::create([
            'homeowner_id' => $homeowner->id,
            'handyman_id' => $handyman->id,
            'service_type' => 'Socket Replacement',
            'description' => 'Replace two broken wall sockets in the living room.',
            'scheduled_at' => Carbon::now()->addDays(5),
            'status' => 'completed',
            'estimated_cost' => 2000.00,
            'final_cost' => 2200.00,
        ]);
    }
}

