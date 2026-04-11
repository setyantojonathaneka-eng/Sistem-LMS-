<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public $timestamps = false;
    protected $fillable = ['course_id', 'title', 'passing_score'];

    public function course() { return $this->belongsTo(Course::class); }
    public function questions() { return $this->hasMany(Question::class); }
    public function attempts() { return $this->hasMany(QuizAttempt::class); }
}
