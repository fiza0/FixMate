<?php 
namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Plumbing', 'description' => 'Professional plumbing services for all your needs'],
            ['name' => 'Electrical Work', 'description' => 'Licensed electricians for safe electrical work'],
            ['name' => 'Carpentry', 'description' => 'Expert carpentry and woodwork services'],
            ['name' => 'Painting', 'description' => 'Interior and exterior painting services'],
            ['name' => 'HVAC Repair', 'description' => 'Heating, ventilation, and air conditioning services'],
            ['name' => 'Appliance Repair', 'description' => 'Fix all types of home appliances'],
            ['name' => 'Landscaping', 'description' => 'Garden and landscape maintenance'],
            ['name' => 'House Cleaning', 'description' => 'Professional cleaning services'],
            ['name' => 'General Handyman', 'description' => 'Jack of all trades for various home repairs'],
            ['name' => 'Furniture Assembly', 'description' => 'Expert furniture assembly services'],
            ['name' => 'TV Mounting', 'description' => 'Professional TV mounting and installation'],
            ['name' => 'Pest Control', 'description' => 'Safe and effective pest elimination'],
        ];

        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'icon' => 'icons/' . Str::slug($service['name']) . '.svg',
                'is_active' => true,
            ]);
        }
    }
}