<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    public $timestamps = false;
    protected $fillable = ['enrollment_id', 'lesson_id', 'is_completed', 'completed_at'];

    public function enrollment() { return $this->belongsTo(Enrollment::class); }
    public function lesson() { return $this->belongsTo(Lesson::class); }
}
