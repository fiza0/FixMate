<?php
namespace Database\Factories;

use App\Models\Handyman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HandymanFactory extends Factory
{
    protected $model = Handyman::class;

    public function definition(): array
    {
        // Nairobi coordinates with some variance
        $baseLatitude = -1.2921;
        $baseLongitude = 36.8219;
        
        return [
            'user_id' => User::factory(),
            'business_name' => $this->faker->company . ' ' . $this->faker->randomElement(['Services', 'Pros', 'Experts', 'Solutions']),
            'bio' => $this->faker->paragraph(3),
            'avatar' => 'avatars/' . $this->faker->lexify('??????') . '.jpg',
            'hourly_rate' => $this->faker->numberBetween(1500, 8000),
            'latitude' => $baseLatitude + $this->faker->randomFloat(4, -0.5, 0.5),
            'longitude' => $baseLongitude + $this->faker->randomFloat(4, -0.5, 0.5),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->randomElement(['Nairobi', 'Westlands', 'Kilimani', 'Karen', 'Lavington']),
            'state' => 'Nairobi County',
            'postal_code' => $this->faker->numberBetween(00100, 00900),
            'rating' => $this->faker->randomFloat(2, 3.5, 5.0),
            'total_reviews' => $this->faker->numberBetween(5, 500),
            'completed_jobs' => $this->faker->numberBetween(10, 1000),
            'is_available' => $this->faker->boolean(85), // 85% available
            'is_verified' => $this->faker->boolean(70), // 70% verified
            'response_time_minutes' => $this->faker->randomElement([5, 10, 15, 30, 60]),
        ];
    }
}
