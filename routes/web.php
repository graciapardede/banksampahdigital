<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman utama (Home) 
Route::get('/', function () {
    return view('home');
});

// Halaman login (form)
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

// Halaman register (form)
Route::get('/register', function () {
    return view('register');
})->middleware('guest');

// Auth actions
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected profile routes (return JSON)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Dashboard for warga only
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();
        if (! $user || ! method_exists($user, 'isWarga') || ! $user->isWarga()) {
            abort(403);
        }
        return view('home');
    })->name('dashboard');
});
