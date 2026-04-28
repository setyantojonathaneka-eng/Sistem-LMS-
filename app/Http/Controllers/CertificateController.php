<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Notifications\CertificateNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    // GET /api/certificates — list sertifikat milik student
    public function index()
    {
        $certificates = Certificate::with('course:id,title,thumbnail')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($certificates);
    }

    // GET /api/certificates/{id} — detail sertifikat
    public function show(Certificate $certificate)
    {
        // Pastikan hanya milik sendiri
        if ($certificate->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $certificate->load('course:id,title,thumbnail', 'user:id,name,email');

        return response()->json($certificate);
    }

    // POST /api/courses/{course}/certificate — generate sertifikat
    public function generate(Course $course)
    {
        // Cek apakah sudah enroll dan completed
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return response()->json([
                'message' => 'Kamu belum enroll course ini'
            ], 400);
        }

        if (!$enrollment->isCompleted()) {
            return response()->json([
                'message' => 'Kamu belum menyelesaikan course ini',
                'progress' => $enrollment->progress_percentage . '%'
            ], 400);
        }

        // Cek apakah sertifikat sudah ada
        $existing = Certificate::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return response()->json([
                'message'     => 'Sertifikat sudah ada',
                'certificate' => $existing,
            ]);
        }

        // Generate sertifikat
        $certificate = Certificate::create([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'issued_at' => now(),
        ]);

        // Kirim notifikasi email
        auth()->user()->notify(new CertificateNotification($certificate, $course));

        return response()->json([
            'message'     => 'Sertifikat berhasil digenerate',
            'certificate' => $certificate->load('course:id,title'),
        ], 201);
    }

    // GET /api/certificates/{number}/verify — verifikasi sertifikat (public)
    public function verify(string $number)
    {
        $certificate = Certificate::with([
            'user:id,name',
            'course:id,title'
        ])->where('certificate_number', $number)->first();

        if (!$certificate) {
            return response()->json([
                'valid'   => false,
                'message' => 'Sertifikat tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'valid'       => true,
            'certificate' => $certificate,
        ]);
    }
}