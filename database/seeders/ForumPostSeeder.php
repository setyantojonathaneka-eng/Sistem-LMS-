<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class ForumPostSeeder extends Seeder
{
    public function run(): void
    {
        $web = Course::where('title', 'Pemrograman Web Dasar')->first();
        $ml  = Course::where('title', 'Machine Learning Intro')->first();

        $posts = [
            [
                'email'   => 'andi@email.com',
                'course'  => $web,
                'content' => 'Saya mencoba import pandas tapi selalu muncul ModuleNotFoundError. Sudah coba pip install tapi masih error. Ada yang bisa bantu?',
            ],
            [
                'email'   => 'siti@email.com',
                'course'  => $ml,
                'content' => 'Sudah berhasil buat web app dengan Flask, sekarang mau deploy ke VPS Ubuntu. Ada panduan step by step yang recommended?',
            ],
            [
                'email'   => 'budiwi@email.com',
                'course'  => $web,
                'content' => 'Halo kak admin, mau tanya Quiz Week 3 untuk materi JavaScript kapan dibuka? Soalnya di dashboard saya belum muncul.',
            ],
        ];

        foreach ($posts as $post) {
            $user = User::where('email', $post['email'])->first();
            ForumPost::create([
                'user_id'   => $user->id,
                'course_id' => $post['course']->id,
                'content'   => $post['content'],
            ]);
        }
    }
}