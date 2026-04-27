<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test student user accounts
        $studentData = [
            [
                'name' => 'John Doe',
                'email' => 'john@student.com',
                'student_id_number' => '2024001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'course_and_section' => 'BSCS 2A',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@student.com',
                'student_id_number' => '2024002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'course_and_section' => 'BSCS 2B',
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@student.com',
                'student_id_number' => '2024003',
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'course_and_section' => 'BSIS 2A',
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah@student.com',
                'student_id_number' => '2024004',
                'first_name' => 'Sarah',
                'last_name' => 'Williams',
                'course_and_section' => 'BSCS 1A',
            ],
        ];

        foreach ($studentData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password123'),
                'is_admin' => false,
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_id_number' => $data['student_id_number'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'course_and_section' => $data['course_and_section'],
            ]);
        }
    }
}
