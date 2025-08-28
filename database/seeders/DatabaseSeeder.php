<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo user for local development
        \App\Models\User::create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Run other seeders
        $this->call([
            ProgramSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
