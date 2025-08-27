<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create some sample student users
        $students = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
            ],
        ];

        foreach ($students as $studentData) {
            $user = User::create($studentData);
            
            // Create sample applications for each student
            $statuses = ['pending', 'under_review', 'accepted', 'rejected'];
            
            // Get a random program ID
            $program = \App\Models\Program::inRandomOrder()->first();
            
            Application::create([
                'user_id' => $user->id,
                'program_id' => $program ? $program->id : null,
                'full_name' => $user->name,
                'email' => $user->email,
                'phone_number' => '+1-555-' . rand(100, 999) . '-' . rand(1000, 9999),
                'date_of_birth' => now()->subYears(rand(18, 25)),
                'gender' => ['male', 'female', 'other'][rand(0, 2)],
                'address' => rand(100, 9999) . ' Main St, City, State ' . rand(10000, 99999),
                'program_of_choice' => $program ? $program->name : 'Unknown Program',
                'previous_education' => 'High School Diploma from ' . ['Lincoln High', 'Washington High', 'Central High'][rand(0, 2)] . ' School. Graduated with honors.',
                'grade_file' => null, // In a real scenario, this would be a file path
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
