<?php
namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Plumbing',
            'Electrical Work',
            'Carpentry',
            'Painting',
            'HVAC Repair',
            'Appliance Repair',
            'Landscaping',
            'Cleaning',
            'Handyman Services',
            'Furniture Assembly',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(20),
            'icon' => 'icons/' . Str::slug($name) . '.svg',
            'is_active' => true,
        ];
    }
}
