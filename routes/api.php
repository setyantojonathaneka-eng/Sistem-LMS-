<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Htpp\Controllers\CourseController;
use App\Htpp\Controllers\LessonProgress;
use App\Htpp\Controllers\EnrollmentController;
use App\Htpp\Controllers\QuizController;
use App\Htpp\Controllers\ForumController;
use App\Htpp\Controllers\CertificateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
