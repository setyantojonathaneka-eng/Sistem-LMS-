<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← tambah
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory; // ← tambah

    protected $fillable = [
        'user_id', 'course_id', 'certificate_number',
        'issued_at', 'file_path',
    ];

    protected $casts = ['issued_at' => 'datetime'];

    protected static function booted()
    {
        static::creating(function ($cert) {
            $cert->certificate_number = strtoupper(Str::random(12));
            $cert->issued_at = now(); 
        });
    }

    public function user()   { return $this->belongsTo(User::class); }
    public function course() { return $this->belongsTo(Course::class); }
}