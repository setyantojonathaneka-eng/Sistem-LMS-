<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Certificate;
use App\Models\Attendance;
use App\Models\AttemptAnswer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function dashboard()
    {
        $enrollments = Enrollment::with('course.lessons', 'course.instructor')->where('user_id', Auth::id())->get();
        $certificates = Certificate::with('course')->where('user_id', Auth::id())->get();
        $quiz_attempts = QuizAttempt::with('quiz')->where('user_id', Auth::id())->latest()->take(5)->get();
        $courses = Course::where('is_published', true)->with('instructor', 'lessons')->latest()->get();
        $todayAttendance = Attendance::where('user_id', Auth::id())->whereDate('created_at', today())->first();
        $attendanceSummary = (object)[
            'present_count' => Attendance::where('user_id', Auth::id())->whereMonth('created_at', now()->month)->count(),
        ];

        $enrolled = $enrollments;
        $overallProgress = $enrollments->count() ? round($enrollments->avg('progress_percentage')) : 0;
        $totalE = $enrollments->count();
        $hadirE = $enrollments->where('progress_percentage', '>=', 100)->count();
        $alfaE  = $totalE - $hadirE;
        $pctE   = $totalE ? round(($hadirE / $totalE) * 100) : 0;
        $attendanceRecap = ['hadir' => $hadirE, 'alfa' => $alfaE, 'total' => $totalE, 'pct' => $pctE];
        $certificatesCount = $certificates->count();

        return view('student.beranda', compact(
            'enrollments', 'enrolled', 'certificates', 'quiz_attempts', 'courses',
            'todayAttendance', 'attendanceSummary', 'overallProgress', 'attendanceRecap', 'certificatesCount'
        ));
    }

    public function joinKelas(Request $request)
    {
        if ($request->filled('course_id')) {
            $course = Course::where('id', $request->course_id)
                ->where('is_published', true)
                ->first();

            if (!$course) {
                return back()->with('join_error', 'Course tidak ditemukan.');
            }
        } else {
            $request->validate(['join_code' => 'required|string']);

            $course = Course::where('join_code', $request->join_code)
                ->where('is_published', true)
                ->first();

            if (!$course) {
                return back()->with('join_error', 'Kode kelas tidak ditemukan.');
            }
        }

        $already = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();

        if ($already) {
            return back()->with('join_error', 'Kamu sudah terdaftar di kelas ini.');
        }

        Enrollment::create([
            'user_id'             => Auth::id(),
            'course_id'           => $course->id,
            'status'              => 'active',
            'enrolled_at'         => now(),
            'progress_percentage' => 0,
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Bergabung ke course',
            'body'    => 'Anda berhasil bergabung ke "' . $course->title . '". Mulai belajar sekarang!',
            'color'   => '#5D9EC7',
            'type'    => 'enrollment',
            'link'    => route('student.course', $course->id),
        ]);

        return back()->with('join_success', 'Berhasil join kelas ' . $course->title . '!');
    }

    // ─── Halaman baru ────────────────────────────────────────────

    public function courses()
    {
        $enrollments = Enrollment::with('course')->where('user_id', Auth::id())->latest()->get();
        $certificates = Certificate::with('course')->where('user_id', Auth::id())->get();
        $quiz_attempts = QuizAttempt::with('quiz')->where('user_id', Auth::id())->latest()->take(5)->get();
        $todayAttendance = Attendance::where('user_id', Auth::id())->whereDate('created_at', today())->first();
        $attendanceSummary = (object)[
            'present_count' => Attendance::where('user_id', Auth::id())->whereMonth('created_at', now()->month)->count(),
        ];

        return view('student.courses', compact(
            'enrollments', 'certificates', 'quiz_attempts', 'todayAttendance', 'attendanceSummary'
        ));
    }

    public function absensi()
    {
        $enrollments = Enrollment::with('course')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $sessions = $enrollments->map(fn($e) => (object)[
            'id'           => $e->id,
            'judul'        => $e->course->title ?? 'Course #' . $e->course_id,
            'course_title' => $e->course->title ?? '-',
            'tanggal'      => $e->created_at->format('d M Y'),
            'jam'          => $e->created_at->format('H:i'),
            'status'       => ($e->progress_percentage ?? 0) >= 100 ? 'hadir' : 'alfa',
            'progress'     => $e->progress_percentage ?? 0,
        ]);

        $total = $enrollments->count();
        $hadir = $enrollments->where('progress_percentage', '>=', 100)->count();
        $alfa  = $total - $hadir;
        $pct   = $total ? round(($hadir / $total) * 100) : 0;
        $attendanceRecap = compact('hadir', 'alfa', 'total', 'pct');

        $certificates = Certificate::with('course')->where('user_id', Auth::id())->get();
        $quiz_attempts = QuizAttempt::with('quiz')->where('user_id', Auth::id())->latest()->take(5)->get();

        return view('student.absensi', compact(
            'sessions', 'attendanceRecap', 'enrollments', 'certificates', 'quiz_attempts'
        ));
    }

    public function nilai()
    {
        $quiz_attempts = QuizAttempt::with('quiz')->where('user_id', Auth::id())->latest()->get();

        $enrollments = Enrollment::with('course')->where('user_id', Auth::id())->get();
        $certificates = Certificate::with('course')->where('user_id', Auth::id())->get();
        $todayAttendance = Attendance::where('user_id', Auth::id())->whereDate('created_at', today())->first();
        $attendanceSummary = (object)[
            'present_count' => Attendance::where('user_id', Auth::id())->whereMonth('created_at', now()->month)->count(),
        ];

        return view('student.nilai', compact(
            'quiz_attempts', 'enrollments', 'certificates', 'todayAttendance', 'attendanceSummary'
        ));
    }

    public function sertifikat()
    {
        $certificates = Certificate::with('course')->where('user_id', Auth::id())->latest()->get();

        $enrollments = Enrollment::with('course')->where('user_id', Auth::id())->get();
        $quiz_attempts = QuizAttempt::with('quiz')->where('user_id', Auth::id())->latest()->take(5)->get();
        $todayAttendance = Attendance::where('user_id', Auth::id())->whereDate('created_at', today())->first();
        $attendanceSummary = (object)[
            'present_count' => Attendance::where('user_id', Auth::id())->whereMonth('created_at', now()->month)->count(),
        ];

        return view('student.sertifikat', compact(
            'certificates', 'enrollments', 'quiz_attempts', 'todayAttendance', 'attendanceSummary'
        ));
    }

    public function downloadCertificate(Certificate $certificate)
    {
        abort_if($certificate->user_id !== Auth::id(), 403);

        $certificate->load('user', 'course');

        $pdf = Pdf::loadView('pdf.certificate', compact('certificate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-' . $certificate->certificate_number . '.pdf');
    }

   public function pengaturan()
{
    $enrollments = Enrollment::with('course')->where('user_id', Auth::id())->get();
    $certificates = Certificate::with('course')->where('user_id', Auth::id())->get();
    $quiz_attempts = QuizAttempt::with('quiz')->where('user_id', Auth::id())->latest()->take(5)->get();
    $todayAttendance = Attendance::where('user_id', Auth::id())->whereDate('created_at', today())->first();
    $attendanceSummary = (object)[
        'present_count' => Attendance::where('user_id', Auth::id())->whereMonth('created_at', now()->month)->count(),
    ];

    return view('student.pengaturan', compact(
        'enrollments', 'certificates', 'quiz_attempts', 'todayAttendance', 'attendanceSummary'
    ));
}

public function updateProfil(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        'photo' => 'nullable|image|max:2048',
    ]);

    $user = Auth::user();
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('photos', 'public');
        $user->photo = $path;
    }

    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui.');
}

public function updateBahasa(Request $request)
{
    $request->validate(['language' => 'required|in:id,en']);

    $user = Auth::user();
    $user->language = $request->language;
    $user->save();

    session(['app_language' => $request->language]);

    return back()->with('success', 'Bahasa berhasil diubah.');
}

public function updateNotifikasi(Request $request)
{
    $user = Auth::user();
    $user->notifications_enabled = $request->has('notifications_enabled');
    $user->save();

    return back()->with('success', 'Pengaturan notifikasi berhasil disimpan.');
}

    // ─────────────────────────────────────────────────────────────

    public function showCourse(Course $course)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lessons = $course->lessons()->orderBy('order')->get();

        $completedLessons = LessonProgress::where('user_id', Auth::id())
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->where('is_completed', true)
            ->pluck('lesson_id');

        return view('student.course', compact('course', 'lessons', 'enrollment', 'completedLessons'));
    }

    public function showLesson(Course $course, Lesson $lesson)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->firstOrFail();

        $quiz = Quiz::where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        return view('student.lesson', compact('course', 'lesson', 'enrollment', 'quiz'));
    }

    public function completeLesson(Lesson $lesson)
    {
        LessonProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'lesson_id' => $lesson->id],
            ['is_completed' => true, 'completed_at' => now()]
        );

        $course      = $lesson->course;
        $totalLesson = $course->lessons->count();
        $completed   = LessonProgress::where('user_id', Auth::id())
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->where('is_completed', true)
            ->count();

        $progress = $totalLesson > 0 ? round($completed / $totalLesson * 100) : 0;

        Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->update([
                'progress_percentage' => $progress,
                'status'              => $progress >= 100 ? 'completed' : 'active',
                'completed_at'        => $progress >= 100 ? now() : null,
            ]);

        if ($progress >= 100) {
            Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Course selesai! 🎉',
                'body'    => 'Selamat! Anda telah menyelesaikan semua lesson di "' . $course->title . '".',
                'color'   => '#69B96F',
                'type'    => 'completion',
                'link'    => route('student.sertifikat'),
            ]);
        } elseif ($progress % 25 === 0) {
            Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Progress ' . $progress . '%',
                'body'    => 'Course "' . $course->title . '" — Anda sudah mencapai ' . $progress . '%!',
                'color'   => '#5D9EC7',
                'type'    => 'progress',
                'link'    => route('student.course', $course->id),
            ]);
        }

        return back()->with('success', 'Lesson selesai!');
    }

    public function quizIndex()
    {
        $quizzes = Quiz::with('course')
            ->whereIn('course_id', Enrollment::where('user_id', Auth::id())->pluck('course_id'))
            ->latest()
            ->get();
        return view('student.quiz-index', compact('quizzes'));
    }

    public function showQuiz(Quiz $quiz)
    {
        $quiz->load('questions.answers');
        return view('student.quiz', compact('quiz'));
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $questions = $quiz->questions()->with('answers')->get();
        $correct   = 0;
        $totalMC   = 0;
        $essayCount = 0;

        foreach ($questions as $question) {
            if ($question->type === 'essay') {
                $essayCount++;
                continue;
            }
            $totalMC++;
            $selected  = $request->input('answers.' . $question->id);
            $isCorrect = $selected && $question->answers()
                ->where('id', $selected)
                ->where('is_correct', true)
                ->exists();
            if ($isCorrect) $correct++;
        }

        $score  = $totalMC > 0 ? round($correct / $totalMC * 100) : ($essayCount > 0 ? 0 : 0);
        $passed = ($totalMC === 0 && $essayCount > 0) ? false : $score >= $quiz->passing_score;

        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score'   => $score,
            'passed'  => $passed,
        ]);

        // Simpan jawaban essay untuk dinilai manual
        foreach ($questions as $question) {
            if ($question->type === 'essay') {
                $essayAnswer = $request->input('essay.' . $question->id);
                if ($essayAnswer) {
                    AttemptAnswer::create([
                        'attempt_id'   => $attempt->id,
                        'question_id'  => $question->id,
                        'answer_text'  => $essayAnswer,
                    ]);
                }
            }
        }

        if ($passed && !$quiz->lesson_id) {
            Certificate::firstOrCreate([
                'user_id'   => Auth::id(),
                'course_id' => $quiz->course_id,
            ]);
        }

        $courseTitle = $quiz->course->title ?? '';
        Notification::create([
            'user_id' => Auth::id(),
            'title'   => $passed ? 'Nilai kuis tersedia ✅' : 'Nilai kuis tersedia ❌',
            'body'    => $passed
                ? 'Selamat! Anda lulus kuis "' . $quiz->title . '" dengan nilai ' . $score . '.'
                : 'Kuis "' . $quiz->title . '" — nilai Anda ' . $score . '. Coba lagi untuk lulus.',
            'color'   => $passed ? '#69B96F' : '#E88774',
            'type'    => 'quiz',
            'link'    => route('student.nilai'),
        ]);

        $essayPending = $essayCount > 0;
        return view('student.result', compact('quiz', 'score', 'passed', 'correct', 'questions', 'essayPending'));
    }
}
