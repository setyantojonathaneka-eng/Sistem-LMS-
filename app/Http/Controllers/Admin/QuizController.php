<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        // Dashboard SPA sudah menampilkan quiz lewat relasi $course->quizzes
        // di AdminController@dashboard, jadi route ini cukup redirect balik.
        return redirect()->route('admin.dashboard');
    }

    public function show(Quiz $quiz)
    {
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'     => 'required|exists:courses,id',
            'title'         => 'required|string|max:200',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        Quiz::create($request->only('course_id', 'title', 'passing_score'));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Quiz berhasil dibuat.');
    }

    public function edit(Quiz $quiz)
    {
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'course_id'     => 'required|exists:courses,id',
            'title'         => 'required|string|max:200',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update($request->only('course_id', 'title', 'passing_score'));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Quiz berhasil diupdate.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'Quiz berhasil dihapus.');
    }
}