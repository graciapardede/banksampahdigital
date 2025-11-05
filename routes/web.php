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

// Protected profile routes
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

Route::middleware(['auth', 'verified', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD Waste Types (yang sudah ada)
    Route::resource('waste-types', \App\Http\Controllers\Admin\WasteTypeController::class);
    
    // CRUD Branches (TAMBAHKAN INI) 👇
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);

    // Dashboard for authenticated users
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
