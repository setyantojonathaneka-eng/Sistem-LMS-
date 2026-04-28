<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CertificateController;

Route::post('/test', function () {
    return response()->json(['message' => 'API POST works!']);
});

// ─── Public Routes ────────────────────────────────────────────
Route::post('/register',   [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/login',      [AuthController::class, 'login']);

// Public — lihat course tanpa login
Route::get('/courses',          [CourseController::class, 'index']);
Route::get('/courses/{course}', [CourseController::class, 'show']);

// Public — verifikasi sertifikat
Route::get('/certificates/verify/{number}', [CertificateController::class, 'verify']);

// ─── Protected Routes ─────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    // ── Instructor & Admin only ──────────────────────────────
    Route::middleware('role:instructor,admin')->group(function () {

        // Course
        Route::post('/courses',                   [CourseController::class, 'store']);
        Route::put('/courses/{course}',           [CourseController::class, 'update']);
        Route::delete('/courses/{course}',        [CourseController::class, 'destroy']);
        Route::patch('/courses/{course}/publish', [CourseController::class, 'togglePublish']);
        Route::get('/instructor/courses',         [CourseController::class, 'myCourses']);

        // Lesson
        Route::post('/courses/{course}/lessons',             [LessonController::class, 'store']);
        Route::put('/courses/{course}/lessons/{lesson}',     [LessonController::class, 'update']);
        Route::delete('/courses/{course}/lessons/{lesson}',  [LessonController::class, 'destroy']);

        // Quiz
        Route::post('/courses/{course}/quizzes',              [QuizController::class, 'store']);
        Route::put('/courses/{course}/quizzes/{quiz}',        [QuizController::class, 'update']);
        Route::delete('/courses/{course}/quizzes/{quiz}',     [QuizController::class, 'destroy']);

        // Enrollment
        Route::get('/courses/{course}/students', [EnrollmentController::class, 'courseStudents']);

        // Forum
        Route::patch('/forum/{forumPost}/pin', [ForumController::class, 'togglePin']);
    });

    // ── Student only ─────────────────────────────────────────
    Route::middleware('role:student')->group(function () {

        // Enrollment
        Route::post('/courses/{course}/enroll',            [EnrollmentController::class, 'enroll']);
        Route::delete('/courses/{course}/unenroll',        [EnrollmentController::class, 'unenroll']);
        Route::get('/my-courses',                          [EnrollmentController::class, 'myCourses']);
        Route::patch('/enrollments/{enrollment}/progress', [EnrollmentController::class, 'updateProgress']);

        // Quiz submit
        Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);

        // Certificate
        Route::get('/certificates',                        [CertificateController::class, 'index']);
        Route::get('/certificates/{certificate}',          [CertificateController::class, 'show']);
        Route::post('/courses/{course}/certificate',       [CertificateController::class, 'generate']);
    });

    // ── Semua role yang login ─────────────────────────────────

    // Lesson
    Route::get('/courses/{course}/lessons',          [LessonController::class, 'index']);
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show']);

    // Quiz
    Route::get('/courses/{course}/quizzes',          [QuizController::class, 'index']);
    Route::get('/courses/{course}/quizzes/{quiz}',   [QuizController::class, 'show']);
    Route::get('/quizzes/{quiz}/my-attempts',        [QuizController::class, 'myAttempts']);

    // Enrollment status
    Route::get('/courses/{course}/enrollment-status', [EnrollmentController::class, 'status']);

    // Forum
    Route::get('/courses/{course}/forum',    [ForumController::class, 'index']);
    Route::post('/courses/{course}/forum',   [ForumController::class, 'store']);
    Route::delete('/forum/{forumPost}',      [ForumController::class, 'destroy']);
});