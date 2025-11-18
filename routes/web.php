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
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);


    // Profil - View (show form) dan API untuk update
    Route::get('/profil', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profil');


    // Profil
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');

    
    // Setor Sampah (read-only untuk user - tampilkan view dengan riwayat)
    Route::get('/setor', function() {
        return view('setor');
    })->name('setor');
    
    // Tukar Poin - View (show form/list reward items)
    Route::get('/tukar-poin', [\App\Http\Controllers\RedemptionController::class, 'create'])->name('tukar-poin');
    
    // Riwayat Transaksi (Deposits + Redemptions)
    Route::get('/riwayat', [\App\Http\Controllers\DepositController::class, 'history'])->name('riwayat');
    
    // Notifikasi
    Route::get('/notifikasi', function () {
        return view('notifikasi');
    })->name('notifikasi');
    
    // Riwayat Penukaran
    Route::get('/riwayat-tukar', [\App\Http\Controllers\RedemptionController::class, 'index'])->name('riwayat-tukar');
    
    // === API Routes untuk User ===
    
    // Profile API
    Route::get('/api/profile', [\App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::put('/api/profile', [\App\Http\Controllers\Api\ProfileController::class, 'update']);
    Route::put('/api/profile/password', [\App\Http\Controllers\Api\ProfileController::class, 'updatePassword']);
    
    // Dashboard API
    Route::get('/api/dashboard', [\App\Http\Controllers\DashboardController::class, 'getData']);
    
    // Deposits API (User - read only)
    Route::get('/api/deposits', [\App\Http\Controllers\DepositController::class, 'index']);
    Route::get('/api/deposits/{id}', [\App\Http\Controllers\DepositController::class, 'show']);
    
    // Redemptions API (User)
    Route::get('/api/redemptions', [\App\Http\Controllers\RedemptionController::class, 'index']);
    Route::post('/api/redemptions', [\App\Http\Controllers\RedemptionController::class, 'store']);
    Route::get('/api/redemptions/{id}', [\App\Http\Controllers\RedemptionController::class, 'show']);
    Route::post('/api/redemptions/{id}/cancel', [\App\Http\Controllers\RedemptionController::class, 'cancel']);
    
    // Reward Items API (untuk list di tukar-poin)
    Route::get('/api/reward-items', [\App\Http\Controllers\RewardItemController::class, 'index']);
    Route::get('/api/reward-items/{id}', [\App\Http\Controllers\RewardItemController::class, 'show']);
    
    // Branches API (untuk dropdown)
    Route::get('/api/branches', [\App\Http\Controllers\BranchController::class, 'index']);
    Route::get('/riwayat-tukar', function () {
        return view('riwayat-tukar');
    })->name('riwayat-tukar');
});

// Admin routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Redirect /admin to /admin/dashboard
    Route::get('/admin', function () {
        return redirect()->route('admin.dashboard');
    });
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'getData']);

    // Manajemen Setoran (Deposits)
    Route::get('/setoran', [\App\Http\Controllers\Admin\DepositController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/create', [\App\Http\Controllers\Admin\DepositController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [\App\Http\Controllers\Admin\DepositController::class, 'store'])->name('setoran.store');
    Route::get('/setoran/{id}', [\App\Http\Controllers\Admin\DepositController::class, 'show'])->name('setoran.show');
    Route::post('/setoran/{id}/confirm', [\App\Http\Controllers\Admin\DepositController::class, 'confirm'])->name('setoran.confirm');
    Route::delete('/setoran/{id}', [\App\Http\Controllers\Admin\DepositController::class, 'destroy'])->name('setoran.destroy');

    // Manajemen Penukaran (Redemptions)
    Route::get('/penukaran', [\App\Http\Controllers\Admin\RedemptionController::class, 'index'])->name('penukaran.index');
    Route::get('/penukaran/{id}', [\App\Http\Controllers\Admin\RedemptionController::class, 'show'])->name('penukaran.show');
    Route::post('/penukaran/{id}/approve', [\App\Http\Controllers\Admin\RedemptionController::class, 'approve'])->name('penukaran.approve');
    Route::post('/penukaran/{id}/reject', [\App\Http\Controllers\Admin\RedemptionController::class, 'reject'])->name('penukaran.reject');
    Route::post('/penukaran/{id}/cancel', [\App\Http\Controllers\Admin\RedemptionController::class, 'cancel'])->name('penukaran.cancel');

    // CRUD Reward Items (Barang Penukaran)
    Route::resource('reward-items', \App\Http\Controllers\Admin\RewardItemController::class);
    Route::post('/reward-items/{rewardItem}/update-stock', [\App\Http\Controllers\Admin\RewardItemController::class, 'updateStock'])->name('reward-items.update-stock');
    // Alias route untuk backward compatibility
    Route::get('/tukar-barang', function () {
        return redirect()->route('admin.reward-items.index');
    })->name('tukar-barang');
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
    
    // CRUD Branches (hanya untuk super admin, bukan admin cabang)
    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
    

    
    // Laporan (Report)
    Route::get('/laporan', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/detail-deposits', [\App\Http\Controllers\Admin\ReportController::class, 'detailDeposits'])->name('laporan.detail-deposits');
    Route::get('/laporan/detail-redemptions', [\App\Http\Controllers\Admin\ReportController::class, 'detailRedemptions'])->name('laporan.detail-redemptions');
    Route::get('/laporan/export-pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('laporan.export-pdf');
});

// Development routes (optional - untuk testing)
});

// Temporary dev routes for previewing views without wiring controllers
Route::view('/_dev/setoran','admin.setoran.index');

Route::view('/_dev/tukar-barang','admin.tukar_barang.index');
Route::view('/_dev/penukaran','admin.penukaran.index');
Route::view('/_dev/waste-types','admin.waste_types.index');


