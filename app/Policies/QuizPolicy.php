<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;

class QuizPolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'instructor';
    }

    public function update(User $user, Quiz $quiz): bool
    {
        return $user->role === 'instructor'
            && $quiz->course->instructor_id === $user->id;
    }

    public function delete(User $user, Quiz $quiz): bool
    {
        return $user->role === 'instructor'
            && $quiz->course->instructor_id === $user->id;
    }
}