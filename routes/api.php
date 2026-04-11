<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonProgress;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CertificateController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Protected routes (butuh token)
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/profile',  [AuthController::class, 'profile']);

    // Courses
    Route::get('/courses', 'App\Http\Controllers\CourseController@index');
    // Lessons
    Route::apiResource('courses.lessons', LessonController::class);

    // Enrollments
    Route::get('/enrollments',      [EnrollmentController::class, 'index']);
    Route::post('/enrollments',     [EnrollmentController::class, 'store']);
    Route::get('/enrollments/{id}', [EnrollmentController::class, 'show']);

    // Quiz
    Route::apiResource('quizzes', QuizController::class);
    Route::post('/quizzes/{id}/submit', [QuizController::class, 'submit']);

    // Forum
    Route::get('/courses/{id}/forum',  [ForumController::class, 'index']);
    Route::post('/courses/{id}/forum', [ForumController::class, 'store']);

    // Certificate
    Route::get('/certificates',      [CertificateController::class, 'index']);
    Route::get('/certificates/{id}', [CertificateController::class, 'show']);
});
