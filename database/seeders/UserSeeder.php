<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@library.com',
            'password' => 'password123',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Librarian User
        User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@library.com',
            'password' => 'password123',
            'role' => 'librarian',
            'email_verified_at' => now(),
        ]);

        // Create Member User
        User::create([
            'name' => 'Member User',
            'email' => 'member@library.com',
            'password' => 'password123',
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        // Create additional sample members
        User::factory()->count(10)->create([
            'role' => 'member',
        ]);
    }
}
