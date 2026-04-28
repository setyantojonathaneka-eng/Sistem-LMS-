<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin & Student
        $admin = User::create([
            'name'              => 'Admin LearnPath',
            'email'             => 'admin@learnpath.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'is_verified'       => 1,
            'email_verified_at' => now(),
        ]);

        $instructor = User::create([
            'name'              => 'Instructor 1',
            'email'             => 'instructor@learnpath.com',
            'password'          => Hash::make('password'),
            'role'              => 'instructor',
            'is_verified'       => 1,
            'email_verified_at' => now(),
        ]);

        $student = User::create([
            'name'              => 'Student 1',
            'email'             => 'student@learnpath.com',
            'password'          => Hash::make('password'),
            'role'              => 'student',
            'is_verified'       => 1,
            'email_verified_at' => now(),
        ]);

        // Courses
    $course1 = Course::create([
        'title'         => 'Artificial Intelligence Class',
        'description'   => 'Belajar dasar-dasar AI dan Machine Learning',
        'instructor_id' => $instructor->id,
        'is_published'  => true,
    ]);

    $course2 = Course::create([
        'title'         => 'Digital Marketing Class',
        'description'   => 'Strategi pemasaran digital untuk bisnis modern',
        'instructor_id' => $instructor->id,
        'is_published'  => true,
    ]);

        // Lessons
    Lesson::create([
        'course_id' => $course1->id,
        'title'     => 'Pengenalan AI',
        'type'      => 'pdf',
        'file_path' => 'lessons/pengenalan-ai.pdf',
        'order'     => 1,
    ]);

    Lesson::create([
        'course_id' => $course1->id,
        'title'     => 'Machine Learning Basics',
        'type'      => 'video',
        'file_path' => 'lessons/ml-basics.mp4',
        'order'     => 2,
    ]);
        // Enrollment
    Enrollment::create([
        'user_id'   => $student->id,
        'course_id' => $course1->id,
        'progress'  => 0,
    ]);
    }
}