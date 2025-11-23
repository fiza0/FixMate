<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@fixmate.test',
            'role' => 'admin',
            'verified' => true,
        ]);

        // some homeowners
        User::factory(5)->create([
            'role' => 'homeowner',
        ]);

        // some handymen
        User::factory(5)->create([
            'role' => 'handyman',
        ]);
    }
}

