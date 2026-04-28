<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = [
        'user_id', 'code', 'type',
        'expires_at', 'used_at',
    ];


    protected $casts = [
        'expires_at' => 'datetime',
        'used_at'    => 'datetime',
    ];

    public function user()      { return $this->belongsTo(User::class); }
    public function isExpired() { return now()->isAfter($this->expires_at); }
    public function isUsed()    { return !is_null($this->used_at); }
    public function isValid()   { return !$this->isExpired() && !$this->isUsed(); }
}