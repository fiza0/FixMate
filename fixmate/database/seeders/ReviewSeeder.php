<?php

namespace Database\Seeders;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $completed = Booking::factory()->count(0); // placeholder if none

        $completed = Booking::where('status', 'completed')->get();

        foreach ($completed as $booking) {
            Review::create([
                'booking_id' => $booking->id,
                'reviewer_id' => $booking->homeowner_id,
                'rating' => rand(3, 5),
                'comment' => 'Great work!',
            ]);
        }
    }
}

