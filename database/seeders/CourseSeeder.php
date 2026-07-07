<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $budi  = User::where('email', 'budi.s@learnpath.com')->first();
        $diana = User::where('email', 'diana.r@learnpath.com')->first();
        $rina  = User::where('email', 'rina.k@learnpath.com')->first();

        $courses = [
            [
                'title'         => 'Pemrograman Web Dasar',
                'description'   => 'Belajar HTML, CSS, dan JavaScript dari nol.',
                'instructor_id' => $budi->id,
                'is_published'  => true,
                'lessons' => [
                    ['title' => 'Intro HTML & Struktur Dasar', 'type' => 'video', 'order' => 1],
                    ['title' => 'CSS Styling & Flexbox',       'type' => 'video', 'order' => 2],
                    ['title' => 'Modul Referensi JavaScript',  'type' => 'pdf',   'order' => 3],
                ],
            ],
            [
                'title'         => 'Machine Learning Intro',
                'description'   => 'Pengenalan Machine Learning dengan Python dan Scikit-learn.',
                'instructor_id' => $diana->id,
                'is_published'  => true,
                'lessons' => [
                    ['title' => 'Pengenalan Machine Learning', 'type' => 'video', 'order' => 1],
                    ['title' => 'Panduan Scikit-learn',        'type' => 'pdf',   'order' => 2],
                ],
            ],
            [
                'title'         => 'UI/UX Fundamentals',
                'description'   => 'Belajar desain UI/UX dengan Figma dan Design Thinking.',
                'instructor_id' => $rina->id,
                'is_published'  => true,
                'lessons' => [
                    ['title' => 'Intro Design Thinking', 'type' => 'video', 'order' => 1],
                    ['title' => 'Figma Basics',          'type' => 'video', 'order' => 2],
                ],
            ],
            [
                'title'         => 'Data Science 101',
                'description'   => 'Belajar Pandas dan Matplotlib untuk analisis data.',
                'instructor_id' => $diana->id,
                'is_published'  => false,
                'lessons'       => [],
            ],
        ];

        foreach ($courses as $data) {
            $lessons = $data['lessons'];
            unset($data['lessons']);

            $course = Course::create($data);

            foreach ($lessons as $lesson) {
                $course->lessons()->create([
                    'title'     => $lesson['title'],
                    'type'      => $lesson['type'],
                    'file_path' => 'placeholder/' . str()->slug($lesson['title']) . '.' . ($lesson['type'] === 'video' ? 'mp4' : 'pdf'),
                    'order'     => $lesson['order'],
                ]);
            }
        }
    }
}