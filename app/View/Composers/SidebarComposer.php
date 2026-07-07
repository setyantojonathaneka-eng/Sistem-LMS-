<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\QuizAttempt;
use App\Models\Attendance;

class SidebarComposer
{
    public function compose(View $view)
    {
        if (!Auth::check()) {
            return;
        }

        $enrollments = Enrollment::with('course')
            ->where('user_id', Auth::id())
            ->get();

        $certificates = Certificate::with('course')
            ->where('user_id', Auth::id())
            ->get();

        $quiz_attempts = QuizAttempt::with('quiz')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->first();

        $attendanceSummary = (object) [
            'present_count' => Attendance::where('user_id', Auth::id())
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        $view->with(compact(
            'enrollments',
            'certificates',
            'quiz_attempts',
            'todayAttendance',
            'attendanceSummary'
        ));
    }
}
