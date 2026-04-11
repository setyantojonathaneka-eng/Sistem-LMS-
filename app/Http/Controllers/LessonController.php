<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index($courseId)
    {
        $lessons = Lesson::where('course_id', $courseId)->orderBy('order')->get();
        return response()->json($lessons);
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'type'        => 'required|in:video,pdf,text',
            'content_url' => 'nullable|string',
            'order'       => 'integer',
        ]);

        $lesson = Lesson::create([
            'course_id'   => $courseId,
            'title'       => $request->title,
            'type'        => $request->type,
            'content_url' => $request->content_url,
            'duration'    => $request->duration,
            'order'       => $request->order ?? 1,
        ]);

        return response()->json(['message' => 'Lesson berhasil dibuat', 'lesson' => $lesson], 201);
    }

    public function show($courseId, $id)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($id);
        return response()->json($lesson);
    }

    public function update(Request $request, $courseId, $id)
    {
        $lesson = Lesson::where('course_id', $courseId)->findOrFail($id);
        $lesson->update($request->only(['title', 'type', 'content_url', 'duration', 'order']));
        return response()->json(['message' => 'Lesson berhasil diupdate', 'lesson' => $lesson]);
    }

    public function destroy($courseId, $id)
    {
        Lesson::where('course_id', $courseId)->findOrFail($id)->delete();
        return response()->json(['message' => 'Lesson berhasil dihapus']);
    }
}
