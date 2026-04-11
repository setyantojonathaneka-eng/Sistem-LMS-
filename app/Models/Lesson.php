<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'type', 'content_url', 'duration', 'order'];

    public function course() { return $this->belongsTo(Course::class); }
    public function lessonProgress() { return $this->hasMany(LessonProgress::class); }
}
