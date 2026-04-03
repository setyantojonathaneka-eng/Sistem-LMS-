<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')->where('is_published', 1)->get();
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
        ]);

        $course = Course::create([
            'instructor_id' => $request->user()->id,
            'title'         => $request->title,
            'description'   => $request->description,
            'is_published'  => $request->is_published ?? 0,
        ]);

        return response()->json(['message' => 'Kursus berhasil dibuat', 'course' => $course], 201);
    }

    public function show($id)
    {
        $course = Course::with(['instructor', 'lessons'])->findOrFail($id);
        return response()->json($course);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->only(['title', 'description', 'is_published']));
        return response()->json(['message' => 'Kursus berhasil diupdate', 'course' => $course]);
    }

    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(['message' => 'Kursus berhasil dihapus']);
    }
}