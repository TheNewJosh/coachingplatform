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
            'email' => 'admin@test.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Coach User',
            'email' => 'coach@test.com',
            'role' => 'coach',
        ]);

        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@test.com',
            'role' => 'student',
        ]);
    }
}
