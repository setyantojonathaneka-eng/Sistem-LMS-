<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'course_id', 'lesson_id', 'title',
        'time_limit', 'passing_score', 'max_attempts',
    ];

    public function course()    { return $this->belongsTo(Course::class); }
    public function lesson()    { return $this->belongsTo(Lesson::class); } // nullable di migration
    public function questions() { return $this->hasMany(Question::class); }
    public function attempts()  { return $this->hasMany(QuizAttempt::class); }
}