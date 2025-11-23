<?php

namespace Database\Factories;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'service_type' => fake()->randomElement(['plumbing', 'electrical', 'painting']),
            'description' => fake()->sentence(8),
            'scheduled_at' => now()->addDays(rand(1, 10)),
            'status' => 'requested',
            'estimated_cost' => rand(1000, 5000),
            'final_cost' => null,
        ];
    }
}

