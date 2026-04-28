<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    // GET /api/courses/{course}/forum — list post di course
    public function index(Course $course)
    {
        // Cek enrollment
        $isEnrolled = $course->enrollments()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->exists();

        $isInstructorOrAdmin = in_array(auth()->user()->role, ['instructor', 'admin']);

        if (!$isEnrolled && !$isInstructorOrAdmin) {
            return response()->json([
                'message' => 'Kamu harus enroll course ini untuk mengakses forum'
            ], 403);
        }

        // Ambil hanya post utama (bukan reply)
        $posts = ForumPost::with([
            'user:id,name,avatar',
            'replies.user:id,name,avatar',
        ])
        ->where('course_id', $course->id)
        ->whereNull('parent_id')
        ->latest()
        ->paginate(10);

        return response()->json($posts);
    }

    // POST /api/courses/{course}/forum — buat post baru
    public function store(Request $request, Course $course)
    {
        // Cek enrollment
        $isEnrolled = $course->enrollments()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->exists();

        $isInstructorOrAdmin = in_array(auth()->user()->role, ['instructor', 'admin']);

        if (!$isEnrolled && !$isInstructorOrAdmin) {
            return response()->json([
                'message' => 'Kamu harus enroll course ini untuk posting di forum'
            ], 403);
        }

        $request->validate([
            'title'     => 'required_without:parent_id|string|max:255',
            'body'      => 'required|string',
            'parent_id' => 'nullable|exists:forum_posts,id',
        ]);

        $post = ForumPost::create([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'parent_id' => $request->parent_id ?? null,
            'title'     => $request->parent_id ? null : $request->title,
            'body'      => $request->body,
            'is_pinned' => false,
        ]);

        $post->load('user:id,name,avatar');

        return response()->json([
            'message' => $request->parent_id ? 'Balasan berhasil dikirim' : 'Post berhasil dibuat',
            'post'    => $post,
        ], 201);
    }

    // DELETE /api/forum/{forumPost} — hapus post
    public function destroy(ForumPost $forumPost)
    {
        // Hanya pemilik post atau admin yang bisa hapus
        if ($forumPost->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Kamu tidak bisa menghapus post ini'], 403);
        }

        $forumPost->delete();

        return response()->json(['message' => 'Post berhasil dihapus']);
    }

    // PATCH /api/forum/{forumPost}/pin — pin/unpin post (instructor/admin)
    public function togglePin(ForumPost $forumPost)
    {
        $forumPost->update(['is_pinned' => !$forumPost->is_pinned]);

        return response()->json([
            'message'   => $forumPost->is_pinned ? 'Post di-pin' : 'Post di-unpin',
            'is_pinned' => $forumPost->is_pinned,
        ]);
    }
}