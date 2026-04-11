<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpCode;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Register
    public function register (Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'requited|email|unique:users',
            'password' => 'requited|min:6|confifmed',
            'role' => 'in:student,instructor',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'student',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register berhasil',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Catat login attempt
        $success = Auth::attempt($request->only('email', 'password'));

        LoginAttempt::create([
            'email'      => $request->email,
            'ip_address' => $request->ip(),
            'is_success' => $success ? 1 : 0,
        ]);

        if (!$success) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }

    // Profile
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}
