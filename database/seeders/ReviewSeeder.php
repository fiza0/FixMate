<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $booking = Booking::where('status', 'completed')->first();
        $homeowner = User::where('email', 'jane@fixmate.com')->first();

        if ($booking && $homeowner) {
            Review::create([
                'booking_id' => $booking->id,
                'reviewer_id' => $homeowner->id,
                'rating' => 5,
                'comment' => 'Excellent service! The electrician was professional and on time.',
            ]);
        }
    }
}
