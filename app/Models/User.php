<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     public function courses() { return $this->hasMany(Course::class, 'instructor_id'); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function quizAttempts() { return $this->hasMany(QuizAttempt::class); }
    public function certificates() { return $this->hasMany(Certificate::class); }
    public function forumPosts() { return $this->hasMany(ForumPost::class); }
    public function otpCodes() { return $this->hasMany(OtpCode::class); }
}
