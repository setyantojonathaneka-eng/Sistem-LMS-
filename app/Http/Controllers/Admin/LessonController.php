<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')->latest()->get();
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        $courses = Course::where('is_published', true)->get();
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'title'        => 'required|string|max:200',
            'type'         => 'required|in:video,pdf',
            'order'        => 'nullable|integer|min:1',
            'file'         => 'nullable|file',
            'external_url' => 'nullable|url',
        ]);

        if (!$request->hasFile('file') && empty($validated['external_url'])) {
            return back()->withErrors([
                'external_url' => 'Upload file atau isi link materi (salah satu wajib diisi).',
            ])->withInput();
        }

        $filePath = $validated['external_url'] ?? null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $allowed = $validated['type'] === 'video'
                ? ['mp4', 'mov', 'avi', 'mkv']
                : ['pdf'];
            $ext = strtolower($file->getClientOriginalExtension());

            if (!in_array($ext, $allowed)) {
                return back()->withErrors([
                    'file' => 'File harus berformat: ' . implode(', ', $allowed) . ' untuk tipe materi ini.',
                ])->withInput();
            }

            $storedPath = $file->store('lessons', 'public');
            $filePath = Storage::url($storedPath);
        }

        Lesson::create([
            'course_id' => $validated['course_id'],
            'title'     => $validated['title'],
            'type'      => $validated['type'],
            'file_path' => $filePath,
            'order'     => $validated['order'] ?? (Lesson::where('course_id', $validated['course_id'])->max('order') + 1),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Materi berhasil diupload.');
    }

    public function show(string $id)
    {
        $lesson = Lesson::with('course')->findOrFail($id);
        return redirect()->route('admin.dashboard');
    }

    public function edit(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $courses = Course::where('is_published', true)->get();
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validated = $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'title'        => 'required|string|max:200',
            'type'         => 'required|in:video,pdf',
            'order'        => 'nullable|integer|min:1',
            'file'         => 'nullable|file',
            'external_url' => 'nullable|url',
        ]);

        $data = [
            'course_id' => $validated['course_id'],
            'title'     => $validated['title'],
            'type'      => $validated['type'],
            'order'     => $validated['order'] ?? $lesson->order,
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

        return redirect()->route('admin.dashboard')
            ->with('success', 'Materi berhasil diupdate.');
    }

    private function deleteOldFileIfLocal(?string $filePath): void
    {
        if (!$filePath) {
            return;
        }
        if (str_starts_with($filePath, '/storage/')) {
            $relativePath = str_replace('/storage/', '', $filePath);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }

    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);

        $this->deleteOldFileIfLocal($lesson->file_path);

        $lesson->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Materi berhasil dihapus.');
    }
}