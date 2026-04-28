<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'avatar', 'is_active', 'email_verified_at', 'is_verified',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
        'password'          => 'hashed',
        'is_verified'       => 'boolean',
    ];

    public function isAdmin()      { return $this->role === 'admin'; }
    public function isInstructor() { return $this->role === 'instructor'; }
    public function isStudent()    { return $this->role === 'student'; }

    public function courses()        { return $this->hasMany(Course::class, 'instructor_id'); }
    public function enrollments()    { return $this->hasMany(Enrollment::class); }
    public function enrolledCourses(){ return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps(); }
    public function certificates()   { return $this->hasMany(Certificate::class); }
    public function forumPosts()     { return $this->hasMany(ForumPost::class); }
    public function quizAttempts()   { return $this->hasMany(QuizAttempt::class); }
    public function lessonProgress() { return $this->hasMany(LessonProgress::class); }
    public function otpCodes()       { return $this->hasMany(OtpCode::class); }
    public function loginAttempts()  { return $this->hasMany(LoginAttempt::class); }
}