<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman utama (Home) 
Route::get('/', function () {
    // Jika sudah login, redirect ke dashboard sesuai role
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect('/admin/dashboard') 
            : redirect('/dashboard');
    }
    return view('home');
});

// Halaman login (form)
Route::get('/login', function () {
    // Jika sudah login, redirect ke dashboard sesuai role
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect('/admin/dashboard') 
            : redirect('/dashboard');
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
    
<<<<<<< Updated upstream
    // Profil
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
=======
    // Profile routes
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Profil - View (show form) dan API untuk update
    Route::get('/profil', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profil');
>>>>>>> Stashed changes
    
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
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Redirect /admin to /admin/dashboard
    Route::get('/admin', function () {
        return redirect()->route('admin.dashboard');
    });
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Manajemen Setoran
    Route::get('/setoran', function () {
        return view('admin.setoran.index');
    })->name('setoran');

    // Manajemen Tukar Barang
    Route::get('/tukar-barang', function () {
        return view('admin.tukar_barang.index');
    })->name('tukar-barang');

    // Daftar Permintaan Penukaran
    Route::get('/penukaran', function () {
        return view('admin.penukaran.index');
    })->name('penukaran');

    // CRUD Waste Types
    Route::resource('waste-types', \App\Http\Controllers\Admin\WasteTypeController::class);
    
<<<<<<< Updated upstream
    // CRUD Branches
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
=======
    // CRUD Branches (hanya untuk super admin, bukan admin cabang)
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
    
    // Laporan (Report)
    Route::get('/laporan', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/detail-deposits', [\App\Http\Controllers\Admin\ReportController::class, 'detailDeposits'])->name('laporan.detail-deposits');
    Route::get('/laporan/detail-redemptions', [\App\Http\Controllers\Admin\ReportController::class, 'detailRedemptions'])->name('laporan.detail-redemptions');
    Route::get('/laporan/export-pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('laporan.export-pdf');
>>>>>>> Stashed changes
});

// Temporary dev routes for previewing views without wiring controllers
Route::view('/_dev/setoran','admin.setoran.index');
Route::view('/_dev/tukar-barang','admin.tukar_barang.index');
Route::view('/_dev/penukaran','admin.penukaran.index');
Route::view('/_dev/waste-types','admin.waste_types.index');


