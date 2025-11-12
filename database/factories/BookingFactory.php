<?php 
namespace Database\Factories;

use App\Models\Booking;
use App\Models\Handyman;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $baseLatitude = -1.2921;
        $baseLongitude = 36.8219;
        
        return [
            'user_id' => User::factory(),
            'handyman_id' => null, // Will be set when accepted
            'service_id' => Service::factory(),
            'booking_type' => $this->faker->randomElement(['now', 'scheduled']),
            'status' => 'pending',
            'customer_name' => $this->faker->name,
            'customer_phone' => $this->faker->phoneNumber,
            'customer_email' => $this->faker->email,
            'service_address' => $this->faker->streetAddress,
            'service_city' => $this->faker->randomElement(['Nairobi', 'Westlands', 'Kilimani']),
            'service_state' => 'Nairobi County',
            'service_postal_code' => $this->faker->numberBetween(00100, 00900),
            'service_latitude' => $baseLatitude + $this->faker->randomFloat(4, -0.5, 0.5),
            'service_longitude' => $baseLongitude + $this->faker->randomFloat(4, -0.5, 0.5),
            'scheduled_start' => null,
            'scheduled_end' => null,
            'description' => $this->faker->paragraph,
            'special_instructions' => $this->faker->optional()->sentence,
            'estimated_hours' => $this->faker->optional()->randomFloat(1, 1, 8),
            'payment_status' => 'pending',
        ];
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_type' => 'scheduled',
            'scheduled_start' => $this->faker->dateTimeBetween('+1 day', '+7 days'),
            'scheduled_end' => $this->faker->dateTimeBetween('+1 day', '+7 days'),
        ]);
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'handyman_id' => Handyman::factory(),
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'handyman_id' => Handyman::factory(),
            'status' => 'completed',
            'accepted_at' => now()->subHours(4),
            'actual_start' => now()->subHours(3),
            'actual_end' => now()->subHour(),
            'completed_at' => now()->subHour(),
            'final_price' => $this->faker->numberBetween(2000, 10000),
            'payment_status' => 'paid',
        ]);
    }
}
