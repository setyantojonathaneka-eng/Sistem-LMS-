<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'status', 'attempted_at'];

    public static function isBlocked($ip)
    {
        $maxAttempts = 5;
        $decayMinutes = 10;

        $attempts = static::where('ip_address', $ip)
            ->where('status', 'failed')
            ->where('attempted_at', '>=', now()->subMinutes($decayMinutes))
            ->count();

        return $attempts >= $maxAttempts;
    }
}