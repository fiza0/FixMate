<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@fixmate.com',
            'password' => Hash::make('password'),
            'phone' => '0712345678',
            'role' => 'admin',
            'verified' => true,
        ]);

        // Homeowner
        User::create([
            'name' => 'Jane Homeowner',
            'email' => 'jane@fixmate.com',
            'password' => Hash::make('password'),
            'phone' => '0711002200',
            'role' => 'homeowner',
            'verified' => true,
        ]);

        // Handyman
        User::create([
            'name' => 'John Handyman',
            'email' => 'john@fixmate.com',
            'password' => Hash::make('password'),
            'phone' => '0798765432',
            'role' => 'handyman',
            'verified' => true,
        ]);
        User::create([
    'name' => 'Peter Plumber',
    'email' => 'peter@fixmate.com',
    'password' => Hash::make('password'),
    'phone' => '0798123456',
    'role' => 'handyman',
    'verified' => true,
]);

    }
}
