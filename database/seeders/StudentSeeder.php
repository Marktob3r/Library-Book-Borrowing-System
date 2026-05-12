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
                'student_id_number' => '202401001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'course' => 'BSCS',
                'year_level' => 2,
                'block' => 'A',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@student.com',
                'student_id_number' => '202401002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'course' => 'BSCS',
                'year_level' => 2,
                'block' => 'B',
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@student.com',
                'student_id_number' => '202401003',
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'course' => 'BSIT',
                'year_level' => 2,
                'block' => 'A',
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah@student.com',
                'student_id_number' => '202401004',
                'first_name' => 'Sarah',
                'last_name' => 'Williams',
                'course' => 'BSCS',
                'year_level' => 1,
                'block' => 'A',
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
                'course' => $data['course'],
                'year_level' => $data['year_level'],
                'block' => $data['block'],
            ]);
        }
    }
}
