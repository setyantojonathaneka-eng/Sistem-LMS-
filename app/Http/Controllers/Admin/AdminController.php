<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use App\Models\Certificate;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_students'   => User::where('role', 'student')->count(),
            'active_courses'   => Course::where('is_published', 1)->count(),
            'certificates'     => Certificate::count(),
            'quiz_submissions' => QuizAttempt::count(),
        ];

        $recent_courses = Course::with('instructor', 'enrollments', 'lessons', 'quizzes.questions')
            ->latest()->take(4)->get();

        $recent_progress = Enrollment::with(['user', 'course'])
            ->latest()->take(4)->get();

        $totalAttempts = QuizAttempt::count();
        $quiz_stats = [
            'completed_today' => QuizAttempt::whereDate('created_at', today())->count(),
            'average_score'   => round(QuizAttempt::avg('score') ?? 0, 1),
            'pass_rate'       => $totalAttempts > 0
                ? round(QuizAttempt::where('passed', true)->count() / $totalAttempts * 100) . '%'
                : '0%',
        ];

        $recent_attempts = QuizAttempt::with(['user', 'quiz.course'])
            ->latest()
            ->take(10)
            ->get();

        $recent_certificates = Certificate::with('user', 'course')
            ->latest()->take(3)->get();

        $recent_forum = ForumPost::with('user', 'course')
            ->latest()->take(3)->get();

        $forum_courses = Course::orderBy('title')->get();

        // Chart data — last 7 days
        $chart_labels = [];
        $chart_signups = [];
        $chart_enrollments = [];
        $chart_certificates = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chart_labels[] = $date->format('D');
            $chart_signups[] = User::whereDate('created_at', $date)->count();
            $chart_enrollments[] = Enrollment::whereDate('created_at', $date)->count();
            $chart_certificates[] = Certificate::whereDate('issued_at', $date)->count();
        }

        return view('admin.admin', compact(
            'stats', 'recent_courses', 'recent_progress',
            'quiz_stats', 'recent_certificates', 'recent_forum', 'recent_attempts', 'forum_courses',
            'chart_labels', 'chart_signups', 'chart_enrollments', 'chart_certificates'
        ));
    }

}