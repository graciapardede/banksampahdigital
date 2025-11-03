<?php

use Illuminate\Support\Facades\Route;

// Halaman utama (Home)
Route::get('/', function () {
    return view('home');
});

// Halaman login
Route::get('/login', function () {
    return view('login');
});

// Halaman register
Route::get('/register', function () {
    return view('register');
});
