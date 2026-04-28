<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/admin', function () {
    return view('ADMIN.admin');
});

Route::get('/tester', function () {
    return view('tester');
});