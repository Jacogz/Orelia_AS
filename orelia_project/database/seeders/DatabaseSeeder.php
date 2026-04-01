<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'address' => '123 Admin St',
            'role' => 'admin',
            'password' => 'adminpassword',
        ]);

        User::factory()->create([
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'address' => '456 User St',
            'role' => 'client',
            'password' => 'userpassword',
        ]);

    }
}
