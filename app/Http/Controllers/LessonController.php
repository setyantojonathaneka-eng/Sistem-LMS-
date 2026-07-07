<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('order')->get();
        return response()->json($lessons);
    }

    public function show(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }
        return response()->json($lesson->load('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:200',
            'type'         => 'required|in:video,pdf',
            'order'        => 'nullable|integer|min:1',
            'file'         => 'nullable|file',
            'external_url' => 'nullable|url',
        ]);

        if (!$request->hasFile('file') && empty($validated['external_url'])) {
            return response()->json([
                'message' => 'Upload file atau isi link materi (salah satu wajib diisi).',
            ], 422);
        }

        $filePath = $validated['external_url'] ?? null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $allowed = $validated['type'] === 'video'
                ? ['mp4', 'mov', 'avi', 'mkv']
                : ['pdf'];
            $ext = strtolower($file->getClientOriginalExtension());

            if (!in_array($ext, $allowed)) {
                return response()->json([
                    'message' => 'File harus berformat: ' . implode(', ', $allowed) . ' untuk tipe materi ini.',
                ], 422);
            }

            $storedPath = $file->store('lessons', 'public');
            $filePath = Storage::url($storedPath);
        }

        $lesson = $course->lessons()->create([
            'title'     => $validated['title'],
            'type'      => $validated['type'],
            'file_path' => $filePath,
            'order'     => $validated['order'] ?? ($course->lessons()->max('order') + 1),
        ]);

        return response()->json($lesson, 201);
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }

        $validated = $request->validate([
            'title'        => 'required|string|max:200',
            'type'         => 'required|in:video,pdf',
            'order'        => 'nullable|integer|min:1',
            'file'         => 'nullable|file',
            'external_url' => 'nullable|url',
        ]);

        $data = [
            'title' => $validated['title'],
            'type'  => $validated['type'],
            'order' => $validated['order'] ?? $lesson->order,
        ];

        if ($request->hasFile('file')) {
            $this->deleteOldFileIfLocal($lesson->file_path);
            $storedPath = $request->file('file')->store('lessons', 'public');
            $data['file_path'] = Storage::url($storedPath);
        } elseif (!empty($validated['external_url'])) {
            $this->deleteOldFileIfLocal($lesson->file_path);
            $data['file_path'] = $validated['external_url'];
        }

        $lesson->update($data);

        return response()->json($lesson);
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }

        $this->deleteOldFileIfLocal($lesson->file_path);
        $lesson->delete();

        return response()->json(['message' => 'Materi berhasil dihapus.']);
    }

    private function deleteOldFileIfLocal(?string $filePath): void
    {
        if (!$filePath) return;
        if (str_starts_with($filePath, '/storage/')) {
            $relativePath = str_replace('/storage/', '', $filePath);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }
}
