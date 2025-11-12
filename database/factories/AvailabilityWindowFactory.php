<?php
namespace Database\Factories;

use App\Models\AvailabilityWindow;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityWindowFactory extends Factory
{
    protected $model = AvailabilityWindow::class;

    public function definition(): array
    {
        return [
            'handyman_id' => Handyman::factory(),
            'day_of_week' => $this->faker->numberBetween(0, 6),
            'start_time' => '08:00:00',
            'end_time' => '18:00:00',
            'is_active' => true,
        ];
    }
}