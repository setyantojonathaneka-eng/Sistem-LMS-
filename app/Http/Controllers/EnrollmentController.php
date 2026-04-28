<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Notifications\EnrollmentNotification;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Course $course)
    {
        if (!$course->is_published) {
            return response()->json(['message' => 'Course ini belum tersedia'], 400);
        }

        $existing = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Kamu sudah terdaftar di course ini'], 400);
        }

        $enrollment = Enrollment::create([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'progress'  => 0,
        ]);

        auth()->user()->notify(new EnrollmentNotification($course));

        return response()->json([
            'message'    => 'Berhasil enroll course',
            'enrollment' => $enrollment,
        ], 201);
    }

    public function unenroll(Course $course)
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return response()->json(['message' => 'Kamu belum terdaftar di course ini'], 404);
        }

        $enrollment->delete();

        return response()->json(['message' => 'Berhasil unenroll course']);
    }

    public function myCourses()
    {
        $enrollments = Enrollment::with(['course' => function ($q) {
                $q->with('instructor:id,name')
                  ->withCount('lessons');
            }])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($enrollments);
    }

    public function status(Course $course)
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return response()->json(['enrolled' => false]);
        }

        return response()->json([
            'enrolled'   => true,
            'progress'   => $enrollment->progress,
            'created_at' => $enrollment->created_at,
        ]);
    }

    public function courseStudents(Course $course)
    {
        if (auth()->user()->role === 'instructor' && $course->instructor_id !== auth()->id()) {
            return response()->json(['message' => 'Kamu tidak punya akses ke course ini'], 403);
        }

        $enrollments = Enrollment::with('user:id,name,email')
            ->where('course_id', $course->id)
            ->latest()
            ->get();

        return response()->json([
            'total'       => $enrollments->count(),
            'enrollments' => $enrollments,
        ]);
    }

    public function updateProgress(Request $request, Enrollment $enrollment)
    {
        if ($enrollment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'progress' => 'required|numeric|min:0|max:100',
        ]);

        $enrollment->update([
            'progress' => $request->progress,
        ]);

        return response()->json([
            'message'    => 'Progress berhasil diupdate',
            'enrollment' => $enrollment,
        ]);
    }
}