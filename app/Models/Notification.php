<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'color', 'type', 'link', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($q)
    {
        return $q->where('is_read', false);
    }

    public function scopeForUser($q, $userId)
    {
        return $q->where('user_id', $userId);
    }

    public function timeForHumans()
    {
        return $this->created_at->diffForHumans();
    }
}
