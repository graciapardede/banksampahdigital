<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman utama (Home) 
Route::get('/', function () {
    // Jika sudah login, redirect ke dashboard
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('home');
});

// Halaman login (form)
Route::get('/login', function () {
    // Jika sudah login, redirect ke dashboard
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('login');
})->name('login');

// Halaman register (form)
Route::get('/register', function () {
    // Jika sudah login, redirect ke dashboard
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('register');
});

// Auth actions
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk force logout (debugging)
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login')->with('message', 'Anda telah logout');
});

// Route untuk debug auth status
Route::get('/debug-auth', function () {
    return [
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
    ];
});

// Protected routes - perlu login
Route::middleware('auth')->group(function () {
    // Dashboard untuk user biasa
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Profil
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
    
    // Setor Sampah
    Route::get('/setor', function () {
        return view('setor');
    })->name('setor');
    
    // Tukar Poin
    Route::get('/tukar-poin', function () {
        return view('tukar-poin');
    })->name('tukar-poin');
    
    // Riwayat Transaksi
    Route::get('/riwayat', function () {
        return view('riwayat');
    })->name('riwayat');
    
    // Notifikasi
    Route::get('/notifikasi', function () {
        return view('notifikasi');
    })->name('notifikasi');
    
    // Riwayat Penukaran
    Route::get('/riwayat-tukar', function () {
        return view('riwayat-tukar');
    })->name('riwayat-tukar');
    
    // Profile routes
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
});

// Admin routes
Route::middleware(['auth', 'verified', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // CRUD Waste Types
    Route::resource('waste-types', \App\Http\Controllers\Admin\WasteTypeController::class);
    
    // CRUD Branches
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
});

