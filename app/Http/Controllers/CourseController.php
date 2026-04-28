<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Tidak perlu __construct() — middleware dipasang di routes/api.php

    // GET /courses — publik (hanya yang published)
    public function index()
    {
        $courses = Course::with('instructor')
            ->where('is_published', 1)
            ->get();

        return response()->json($courses);
    }

    // GET /api/instructor/courses
public function myCourses()
{
    $courses = Course::with('instructor')
        ->where('instructor_id', Auth::id())
        ->latest()
        ->get();

    return response()->json($courses);
}

// PATCH /api/courses/{course}/publish
public function togglePublish(Course $course)
{
    if (Auth::user()->role !== 'admin' && $course->instructor_id !== Auth::id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $course->update([
        'is_published' => !$course->is_published,
    ]);

    return response()->json([
        'message' => 'Status publish berhasil diubah',
        'course'  => $course,
    ]);
}

    // POST /courses
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:200',
            'description'  => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $course = Course::create([
            'instructor_id' => Auth::id(),
            'title'         => $request->title,
            'description'   => $request->description,
            'is_published'  => $request->is_published ?? 0,
        ]);

        return response()->json([
            'message' => 'Kursus berhasil dibuat',
            'course'  => $course,
        ], 201);
    }

    // GET /courses/{id}
    public function show($id)
    {
        $course = Course::with(['instructor', 'lessons'])->findOrFail($id);
        return response()->json($course);
    }

    // PUT /courses/{id}
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $course->instructor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title'        => 'sometimes|string|max:200',
            'description'  => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $course->update($request->only(['title', 'description', 'is_published']));

        return response()->json([
            'message' => 'Kursus berhasil diupdate',
            'course'  => $course,
        ]);
    }

    // DELETE /courses/{id}
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $course->instructor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $course->delete();

        return response()->json(['message' => 'Kursus berhasil dihapus']);
    }
}