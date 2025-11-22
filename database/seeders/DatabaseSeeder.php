<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
         User::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '+254712345678',
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

         // Seed services
        $this->call(ServiceSeeder::class);

        // Seed handymen
        $this->call(HandymanSeeder::class);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Test credentials:');
        $this->command->info('Customer: customer@example.com / password');
        $this->command->info('Handymen: handyman1@example.com to handyman50@example.com / password');
    }
    
}
