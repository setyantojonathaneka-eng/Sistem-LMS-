<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['email' => 'andi@email.com',   'course' => 'Pemrograman Web Dasar', 'score' => 92],
            ['email' => 'maya@email.com',   'course' => 'UI/UX Fundamentals',    'score' => 95],
            ['email' => 'budiwi@email.com', 'course' => 'UI/UX Fundamentals',    'score' => 88],
        ];

        foreach ($data as $item) {
            $user   = User::where('email', $item['email'])->first();
            $course = Course::where('title', $item['course'])->first();

            Certificate::create([
                'user_id'            => $user->id,
                'course_id'          => $course->id,
                'certificate_number' => 'CERT-' . date('Y') . '-' . str_pad(rand(1, 999), 4, '0', STR_PAD_LEFT),
                'issued_at'          => now()->subDays(rand(1, 10)),
            ]);
        }
    }
}