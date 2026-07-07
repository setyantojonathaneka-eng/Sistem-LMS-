<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return redirect()->route('admin.dashboard');
    }

    public function show(User $user)
    {
        return redirect()->route('admin.dashboard');
    }

    public function edit(User $user)
    {
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, User $user)
    {
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,instructor,student',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'role'              => $request->role,
            'password'          => Hash::make($request->password),
            'is_verified'       => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'password123'; 

        $user->update([
            'password' => bcrypt($newPassword),
        ]);

        return back()->with('success', "Password untuk {$user->name} berhasil di-reset ke: {$newPassword}");
    }
}
