<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('user', 'course')->latest()->get();
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        $courses  = Course::where('is_published', true)->get();
        return view('admin.enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        Enrollment::firstOrCreate(
            ['user_id' => $request->user_id, 'course_id' => $request->course_id],
            ['status' => 'active', 'enrolled_at' => now(), 'progress_percentage' => 0]
        );

        return redirect()->route('admin.dashboard')
            ->with('success', 'Student berhasil di-enroll.');
    }

    public function show(Enrollment $enrollment)
    {
        return redirect()->route('admin.dashboard');
    }

    public function edit(Enrollment $enrollment)
    {
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        return redirect()->route('admin.dashboard');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'Student berhasil di-unenroll.');
    }
}
