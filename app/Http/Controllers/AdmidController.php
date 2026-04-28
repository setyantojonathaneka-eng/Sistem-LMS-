<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use App\Models\Certificate;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'active_courses' => Course::where('is_published', 1)->count(),
            'certificates_issued' => Certificate::count(),
            'quiz_submissions' => QuizAttempt::count(),
        ];

        $recent_courses = Course::with('instructor')
            ->latest()
            ->take(4)
            ->get();

        $recent_progress = Enrollment::with(['user', 'course'])
            ->latest('enrolled_at')
            ->take(4)
            ->get();

        return view('ADMIN.admin', compact('stats', 'recent_courses', 'recent_progress'));
    }
}