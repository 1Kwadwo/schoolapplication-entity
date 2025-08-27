<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Bachelor of Computer Science',
                'description' => 'A comprehensive program covering software development, algorithms, and computer systems.',
                'duration' => '4 years',
                'tuition_fee' => 15000.00,
                'capacity' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Bachelor of Business Administration',
                'description' => 'Learn business fundamentals, management, and entrepreneurship skills.',
                'duration' => '4 years',
                'tuition_fee' => 12000.00,
                'capacity' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Master of Engineering',
                'description' => 'Advanced engineering studies with specialization options.',
                'duration' => '2 years',
                'tuition_fee' => 20000.00,
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Associate Degree in Arts',
                'description' => 'Foundation program in liberal arts and humanities.',
                'duration' => '2 years',
                'tuition_fee' => 8000.00,
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Certificate in Digital Marketing',
                'description' => 'Short-term program focused on modern marketing techniques.',
                'duration' => '6 months',
                'tuition_fee' => 5000.00,
                'capacity' => 25,
                'is_active' => true,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
