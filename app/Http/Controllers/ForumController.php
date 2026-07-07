<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function webIndex()
    {
        $courses = Course::whereHas('enrollments', function ($q) {
            $q->where('user_id', auth()->id())->where('status', 'active');
        })->orWhere('instructor_id', auth()->id())->with('forumPosts')->get();

        $forumCourses = $courses->map(fn($c) => [
            'id'         => $c->id,
            'title'      => $c->title,
            'post_count' => $c->forumPosts->count(),
        ])->values();

        return view('forum.index', compact('forumCourses'));
    }

    // Web: GET /forum/{course} — chat bubble view per course
    public function webShow(Course $course)
    {
        $courses = Course::whereHas('enrollments', function ($q) {
            $q->where('user_id', auth()->id())->where('status', 'active');
        })->orWhere('instructor_id', auth()->id())->get();

        return view('forum.chat', compact('course', 'courses'));
    }

    public function webStore(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title'     => 'required|string|max:255',
            'body'      => 'required|string',
        ]);

        ForumPost::create([
            'user_id'   => auth()->id(),
            'course_id' => $request->course_id,
            'title'     => $request->title,
            'body'      => $request->body,
        ]);

        return redirect()->route('forum.index')->with('success', 'Post berhasil dibuat!');
    }
    // GET /api/courses/{course}/forum — list post di course
    // ?since=2026-07-07T12:00:00 — hanya kirim post setelah waktu itu (polling)
    public function index(Course $course, Request $request)
    {
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

        $query = ForumPost::with('user:id,name,avatar,role')
            ->where('course_id', $course->id);

        if ($request->since) {
            $query->where('created_at', '>', $request->since);
        }

        $posts = $query->orderBy('created_at')->take(100)->get();

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
