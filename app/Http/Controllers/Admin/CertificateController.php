<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('user', 'course')->latest()->get();
        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        $courses  = Course::where('is_published', true)->get();
        return view('admin.certificates.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        Certificate::create([
            'user_id'            => $request->user_id,
            'course_id'          => $request->course_id,
            'certificate_number' => 'CERT-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'issued_at'          => now(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Sertifikat berhasil digenerate.');
    }

    public function show(Certificate $certificate)
    {
        return redirect()->route('admin.dashboard');
    }

    public function edit(Certificate $certificate)
    {
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, Certificate $certificate)
    {
        return redirect()->route('admin.dashboard');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
