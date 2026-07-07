<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $web  = Course::where('title', 'Pemrograman Web Dasar')->first();
        $ml   = Course::where('title', 'Machine Learning Intro')->first();
        $uiux = Course::where('title', 'UI/UX Fundamentals')->first();
        $ds   = Course::where('title', 'Data Science 101')->first();

        $enrollments = [
            ['email' => 'andi@email.com',   'course' => $web,  'progress' => 72, 'status' => 'active'],
            ['email' => 'siti@email.com',   'course' => $ml,   'progress' => 45, 'status' => 'active'],
            ['email' => 'budiwi@email.com', 'course' => $uiux, 'progress' => 88, 'status' => 'active'],
            ['email' => 'diana@email.com',  'course' => $ds,   'progress' => 30, 'status' => 'active'],
            ['email' => 'maya@email.com',   'course' => $uiux, 'progress' => 100,'status' => 'completed'],
            ['email' => 'rudi@email.com',   'course' => $ml,   'progress' => 79, 'status' => 'active'],
        ];

        foreach ($enrollments as $data) {
            $user = User::where('email', $data['email'])->first();
            Enrollment::create([
                'user_id'              => $user->id,
                'course_id'            => $data['course']->id,
                'status'               => $data['status'],
                'progress_percentage'  => $data['progress'],
                'enrolled_at'          => now()->subDays(rand(5, 20)),
                'completed_at'         => $data['status'] === 'completed' ? now() : null,
            ]);
        }
    }
}