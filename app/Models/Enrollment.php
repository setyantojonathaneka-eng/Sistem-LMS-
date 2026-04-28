<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'status',
        'enrolled_at', 'completed_at', 'progress_percentage',
    ];

    protected $casts = [
        'enrolled_at'         => 'datetime',
        'completed_at'        => 'datetime',
        'progress_percentage' => 'float',
    ];

    // status: 'active', 'completed', 'cancelled'

    public function user()   { return $this->belongsTo(User::class); }
    public function course() { return $this->belongsTo(Course::class); }

    public function isCompleted() { return $this->status === 'completed'; }
    public function isActive()    { return $this->status === 'active'; }
}