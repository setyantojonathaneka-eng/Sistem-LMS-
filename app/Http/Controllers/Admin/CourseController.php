<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function show(Course $course)
    {
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        $instructors = User::where('role', 'instructor')->get();
        return view('admin.courses.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $request->validate([
            'title'         => 'required|string|max:200',
            'description'   => 'nullable|string',
            'instructor_id' => 'required|exists:users,id',
            'is_published'  => 'boolean',
        ]);

        Course::create($request->only('title', 'description', 'instructor_id', 'is_published'));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $instructors = User::where('role', 'instructor')->get();
        return view('admin.courses.edit', compact('course', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'title'         => 'required|string|max:200',
            'description'   => 'nullable|string',
            'instructor_id' => 'required|exists:users,id',
            'is_published'  => 'boolean',
        ]);

        $course->update($request->only('title', 'description', 'instructor_id', 'is_published'));

        return redirect()->route('admin.dashboard', ['page' => 'courses'])
            ->with('success', 'Kursus berhasil diupdate.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Kursus berhasil dihapus.');
    }
}