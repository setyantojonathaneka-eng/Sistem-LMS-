<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpCode;
use App\Models\LoginAttempt;
use App\Notifications\OtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:6|confirmed',
            'role' => 'in:student,instructor,admin',
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role'=> $request->role ?? 'student',
        ]);

        // Kirim OTP verifikasi email
        $otp = OtpCode::create([
            'user_id'    => $user->id,
            'email'      => $user->email, 
            'code'       => rand(100000, 999999),
            'type'       => 'email_verification',
            'expires_at' => now()->addMinutes(20), 
        ]);

        $user->notify(new OtpNotification($otp->code));

        return response()->json([
            'message'  => 'Register berhasil, cek email untuk verifikasi',
            'user'     => $user,
            'otp_code' => $otp->code, 
        ], 201);
    }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $otp = OtpCode::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('type', 'email_verification')
            ->latest()
            ->first();

        if (!$otp || !$otp->isValid()) {
            return response()->json(['message' => 'OTP tidak valid atau sudah expired'], 422);
        }

        $otp->update(['used_at' => now()]);
        $user->update(['email_verified_at' => now(), 'is_verified' => 1]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Email berhasil diverifikasi',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah IP diblokir
        if (LoginAttempt::isBlocked($request->ip())) {
            return response()->json([
                'message' => 'Terlalu banyak percobaan login. Coba lagi dalam 10 menit.'
            ], 429);
        }

        $success = Auth::attempt($request->only('email', 'password'));

        LoginAttempt::create([
            'user_id'      => $success ? Auth::id() : null,
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'status'       => $success ? 'success' : 'failed',
            'attempted_at' => now(),
        ]);

        if (!$success) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $user = Auth::user();

        if (!$user->is_verified) {
            Auth::logout();
            return response()->json(['message' => 'Email kamu belum diverifikasi. Cek email untuk kode OTP.'], 403);
        }

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

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $otp = OtpCode::create([
            'user_id'    => $user->id,
            'email'      => $user->email,
            'code'       => rand(100000, 999999),
            'type'       => 'email_verification',
            'expires_at' => now()->addMinutes(20), 
        ]);

        $user->notify(new OtpNotification($otp->code));

        return response()->json([
            'message'  => 'OTP baru telah dikirim.',
            'otp_code' => $otp->code, 
        ]);
    }
}