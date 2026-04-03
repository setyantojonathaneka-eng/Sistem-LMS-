<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $fillable = ['course_id', 'user_id', 'parent_id', 'content'];

    public function course() { return $this->belongsTo(Course::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function parent() { return $this->belongsTo(ForumPost::class, 'parent_id'); }
    public function replies() { return $this->hasMany(ForumPost::class, 'parent_id'); }
}
