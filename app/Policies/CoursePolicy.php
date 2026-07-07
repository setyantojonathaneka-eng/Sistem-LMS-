<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    public function update(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->instructor_id === $user->id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->instructor_id === $user->id;
    }
}