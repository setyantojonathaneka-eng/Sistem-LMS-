<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttemptAnswer extends Model
{
    protected $fillable = ['attempt_id', 'question_id', 'answer_text', 'score'];

    public function attempt() { return $this->belongsTo(QuizAttempt::class); }
    public function question() { return $this->belongsTo(Question::class); }
}
