<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $web = Course::where('title', 'Pemrograman Web Dasar')->first();
        $ml  = Course::where('title', 'Machine Learning Intro')->first();

        // Quiz Web Dasar
        $quiz1 = Quiz::create([
            'course_id'     => $web->id,
            'title'         => 'Quiz Week 1',
            'passing_score' => 70,
        ]);

        $q1 = $quiz1->questions()->create(['question' => 'Tag HTML untuk heading terbesar adalah?']);
        $q1->answers()->createMany([
            ['answer' => '<h6>',    'is_correct' => false],
            ['answer' => '<h1>',    'is_correct' => true],
            ['answer' => '<header>','is_correct' => false],
            ['answer' => '<title>', 'is_correct' => false],
        ]);

        $q2 = $quiz1->questions()->create(['question' => 'CSS property untuk mengubah warna teks adalah?']);
        $q2->answers()->createMany([
            ['answer' => 'background-color', 'is_correct' => false],
            ['answer' => 'font-style',       'is_correct' => false],
            ['answer' => 'color',            'is_correct' => true],
            ['answer' => 'text-color',       'is_correct' => false],
        ]);

        // Quiz ML
        $quiz2 = Quiz::create([
            'course_id'     => $ml->id,
            'title'         => 'UTS ML',
            'passing_score' => 70,
        ]);

        $q3 = $quiz2->questions()->create(['question' => 'Library Python untuk Machine Learning yang paling populer adalah?']);
        $q3->answers()->createMany([
            ['answer' => 'NumPy',      'is_correct' => false],
            ['answer' => 'Pandas',     'is_correct' => false],
            ['answer' => 'Scikit-learn','is_correct' => true],
            ['answer' => 'Matplotlib', 'is_correct' => false],
        ]);
    }
}