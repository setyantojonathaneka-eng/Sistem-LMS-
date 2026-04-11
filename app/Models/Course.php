<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['instructor_id', 'title', 'description', 'thumbnail', 'is_published'];

    public function instructor() { return $this->belongsTo(User::class, 'instructor_id'); }
    public function lessons() { return $this->hasMany(Lesson::class); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function quizzes() { return $this->hasMany(Quiz::class); }
    public function certificates() { return $this->hasMany(Certificate::class); }
    public function forumPosts() { return $this->hasMany(ForumPost::class); }
}
