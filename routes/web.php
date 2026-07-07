<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\GradeController as AdminGradeController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\ForumController as AdminForumController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProgressController as AdminProgressController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\ForumController;

// Landing
Route::get('/', fn() => view('landing'));

// Auth
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login',  [AuthController::class, 'webLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');


// Admin & Instructor
Route::prefix('admin')->middleware(['auth', 'role:admin,instructor'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin & Instructor boleh akses
    Route::resource('courses',  AdminCourseController::class)->names('admin.courses');
    Route::resource('lessons',  AdminLessonController::class)->names('admin.lessons');
    Route::resource('quizzes',  AdminQuizController::class)->names('admin.quizzes');

    // Kelola Soal per Quiz
    Route::get('/quizzes/{quiz}/questions', [AdminQuestionController::class, 'index'])->name('admin.quizzes.questions.index');
    Route::post('/quizzes/{quiz}/questions', [AdminQuestionController::class, 'store'])->name('admin.quizzes.questions.store');
    Route::delete('/quizzes/{quiz}/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('admin.quizzes.questions.destroy');

    // Penilaian Essay
    Route::get('/quizzes/{quiz}/grade', [AdminGradeController::class, 'index'])->name('admin.quizzes.grade.index');
    Route::post('/quizzes/{quiz}/grade/{attempt}', [AdminGradeController::class, 'update'])->name('admin.quizzes.grade.update');

    Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

    Route::middleware('role:admin')->group(function () {
    Route::resource('enrollments',   AdminEnrollmentController::class)->names('admin.enrollments');
    Route::resource('certificates',  AdminCertificateController::class)->names('admin.certificates');
    Route::resource('forum',         AdminForumController::class)->names('admin.forum');
    Route::resource('users',         AdminUserController::class)->names('admin.users');
    Route::get('progress',           [AdminProgressController::class, 'index'])->name('admin.progress');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset-password');
    });
});

// Student
Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/',                                [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::post('/join',                            [StudentController::class, 'joinKelas'])->name('student.join');

    Route::get('/courses',                          [StudentController::class, 'courses'])->name('student.mycourses');
    Route::get('/absensi',                          [StudentController::class, 'absensi'])->name('student.absensi');
    Route::get('/nilai',                            [StudentController::class, 'nilai'])->name('student.nilai');
    Route::get('/sertifikat',                       [StudentController::class, 'sertifikat'])->name('student.sertifikat');
    Route::get('/certificate/{certificate}/download', [StudentController::class, 'downloadCertificate'])->name('student.certificate.download');
    Route::get('/pengaturan',                       [StudentController::class, 'pengaturan'])->name('student.pengaturan');
    Route::post('/pengaturan/profil',                   [StudentController::class, 'updateProfil'])->name('student.pengaturan.profil');
    Route::post('/pengaturan/bahasa',                   [StudentController::class, 'updateBahasa'])->name('student.pengaturan.bahasa');
    Route::post('/pengaturan/notifikasi',               [StudentController::class, 'updateNotifikasi'])->name('student.pengaturan.notifikasi');
    

    Route::get('/course/{course}',                  [StudentController::class, 'showCourse'])->name('student.course');
    Route::get('/course/{course}/lesson/{lesson}',  [StudentController::class, 'showLesson'])->name('student.lesson');
    Route::post('/lesson/{lesson}/complete',        [StudentController::class, 'completeLesson'])->name('student.lesson.complete');
    Route::get('/quizzes',                          [StudentController::class, 'quizIndex'])->name('student.quiz.index');
    Route::get('/quiz/{quiz}',                      [StudentController::class, 'showQuiz'])->name('student.quiz');
    Route::post('/quiz/{quiz}/submit',              [StudentController::class, 'submitQuiz'])->name('student.quiz.submit');

    
});

Route::middleware('auth')->group(function () {
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkin'])->name('attendance.checkin');

    Route::get('/forum', [ForumController::class, 'webIndex'])->name('forum.index');
    Route::get('/forum/{course}/chat', [ForumController::class, 'webShow'])->name('forum.chat');
    Route::get('/forum/create', function () {
        return view('forum.create');
    })->name('forum.create');
    Route::post('/forum', [ForumController::class, 'webStore'])->name('forum.store');

    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.readAll');
});