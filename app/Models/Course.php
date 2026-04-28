<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'thumbnail',
        'instructor_id', 'category', 'level', 'price',
        'is_published', 'duration_minutes',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price'        => 'decimal:2',
    ];

    public function instructor()    { return $this->belongsTo(User::class, 'instructor_id'); }
    public function lessons()       { return $this->hasMany(Lesson::class)->orderBy('order'); }
    public function enrollments()   { return $this->hasMany(Enrollment::class); }
    public function students()      { return $this->belongsToMany(User::class, 'enrollments')->withTimestamps(); }
    public function quizzes()       { return $this->hasMany(Quiz::class); }
    public function certificates()  { return $this->hasMany(Certificate::class); }
    public function forumPosts()    { return $this->hasMany(ForumPost::class); }
    public function lessonProgress(){ return $this->hasMany(LessonProgress::class); }

}