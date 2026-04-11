<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;
    protected $fillable = ['quiz_id', 'question_text', 'type', 'order'];

    public function quiz() { return $this->belongsTo(Quiz::class); }
    public function answers() { return $this->hasMany(Answer::class); }
}
