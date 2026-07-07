<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $posts = ForumPost::with('user', 'course')->latest()->get();
        return view('admin.forum.index', compact('posts'));
    }

    public function create()
    {
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.dashboard');
    }

    public function show(ForumPost $forum)
    {
        return redirect()->route('admin.dashboard');
    }

    public function edit(ForumPost $forum)
    {
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, ForumPost $forum)
    {
        return redirect()->route('admin.dashboard');
    }

    public function destroy(ForumPost $forum)
    {
        $forum->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'Post berhasil dihapus.');
    }
}
