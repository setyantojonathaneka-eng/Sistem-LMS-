<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\TesterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TesterController::class, 'index']);