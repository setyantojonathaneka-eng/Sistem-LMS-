<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'instructor'; // hanya instructor yang upload materi
    }

    public function update(User $user, Lesson $lesson): bool
    {
        return $user->role === 'instructor'
            && $lesson->course->instructor_id === $user->id;
    }

    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->role === 'instructor'
            && $lesson->course->instructor_id === $user->id;
    }
}