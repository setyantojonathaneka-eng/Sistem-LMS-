<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'code', 'purpose', 'is_used', 'expired_at'];

    public function user() { return $this->belongsTo(User::class); }
}
