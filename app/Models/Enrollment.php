<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
     public $timestamps = false;
    protected $fillable = ['user_id', 'course_id', 'progress'];
    protected $dates = ['enrolled_at'];

    public function user() { return $this->belongsTo(User::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function lessonProgress() { return $this->hasMany(LessonProgress::class); }
}
