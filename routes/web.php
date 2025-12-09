<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\EcoNewsController;

// Halaman utama (Home) 
Route::get('/', function () {
    // Jika sudah login, redirect ke dashboard sesuai role
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect('/admin/dashboard') 
            : redirect('/dashboard');
    }
    return view('welcome');
});

// Halaman login (form)
Route::get('/login', function () {
    // Jika sudah login, redirect ke dashboard sesuai role
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect('/admin/dashboard') 
            : redirect('/dashboard');
    }
    return view('auth.login');
})->name('login');

// Halaman register (form)
Route::get('/register', function () {
    // Jika sudah login, redirect ke dashboard
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('auth.register');
})->name('register');

// Auth actions
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Unlink Google Account (authenticated users only)
Route::post('/auth/google/unlink', [GoogleAuthController::class, 'unlinkGoogle'])
    ->middleware('auth')
    ->name('auth.google.unlink');

// Eco News Routes (Public - accessible without login)
Route::get('/eco-news/articles', [EcoNewsController::class, 'index'])->name('eco.news.index'); // Halaman daftar semua artikel
Route::get('/eco-news', [EcoNewsController::class, 'search'])->name('eco.news.search'); // Halaman search/cari berita
Route::get('/eco-news/{id}', [EcoNewsController::class, 'show'])->name('eco.news.show'); // Detail artikel

// Location Routes (Public - Google Maps integration)
Route::get('/lokasi', [\App\Http\Controllers\LocationController::class, 'index'])->name('lokasi.index');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Link verifikasi telah dikirim ke email Anda!');
    })->middleware('throttle:6,1')->name('verification.send');
});

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
    // Dashboard untuk user biasa - DENGAN NO-CACHE untuk data real-time
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('no.cache'); // Prevent stale data - always fetch fresh from DB
    
    // Profile routes (API)
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Profil - Route Group
    Route::prefix('profil')->name('profil.')->controller(\App\Http\Controllers\ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');                       // Halaman utama read-only
        Route::get('/edit', 'edit')->name('edit');                     // Form edit data diri
        Route::put('/update', 'update')->name('update');               // Action simpan data
        Route::get('/password', 'editPassword')->name('password');     // Form ganti password
        Route::put('/password', 'updatePassword')->name('password.update'); // Action simpan password
    });

    
    // Setor Sampah (read-only untuk user - tampilkan view dengan riwayat)
    Route::get('/setor', [\App\Http\Controllers\SetorController::class, 'index'])->name('setor');
    
    // Tukar Poin - View (show form/list reward items)
    Route::get('/tukar-poin', [\App\Http\Controllers\RedemptionController::class, 'create'])->name('tukar-poin');
    
    // === CART SYSTEM ROUTES ===
    // Detail Item (before adding to cart)
    Route::get('/tukar/{rewardItem}/detail', [\App\Http\Controllers\CartController::class, 'detail'])->name('tukar.detail');
    
    // Cart Management
    Route::post('/cart/add/{rewardItem}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{rewardItem}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{rewardItem}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout (process redemption from cart)
    Route::post('/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    
    // Instant Redeem (skip cart, direct checkout for single item)
    Route::post('/tukar/{rewardItem}/instant', [\App\Http\Controllers\CartController::class, 'instantRedeem'])->name('tukar.instant');
    
    // Riwayat Transaksi (Deposits + Redemptions) - DENGAN NO-CACHE untuk status terbaru
    Route::get('/riwayat', [\App\Http\Controllers\DepositController::class, 'history'])
        ->name('riwayat')
        ->middleware('no.cache'); // Always show latest transaction status
    
    // Detail Transaksi (Deposit atau Redemption)
    Route::get('/riwayat/{id}/{type}', [\App\Http\Controllers\DepositController::class, 'showDetail'])
        ->name('riwayat.detail')
        ->middleware('no.cache');
    
    // Notifikasi
    Route::get('/notifikasi', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifikasi');
    Route::get('/notifikasi/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    Route::get('/api/notifikasi/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifikasi.unread-count');
    
    // Riwayat Penukaran (redirect to riwayat page)
    Route::get('/riwayat-tukar', function () {
        return redirect()->route('riwayat');
    })->name('riwayat-tukar');
    
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
    // Route::post('/setoran/{id}/confirm', ...) → REMOVED (One-Click Verification active)
    Route::delete('/setoran/{id}', [\App\Http\Controllers\Admin\DepositController::class, 'destroy'])->name('setoran.destroy');

    // Manajemen Penukaran (Redemptions)
    Route::get('/penukaran', [\App\Http\Controllers\Admin\RedemptionController::class, 'index'])->name('penukaran.index');
    Route::get('/penukaran/{id}', [\App\Http\Controllers\Admin\RedemptionController::class, 'show'])->name('penukaran.show');
    Route::post('/penukaran/{id}/approve', [\App\Http\Controllers\Admin\RedemptionController::class, 'approve'])->name('penukaran.approve');
    Route::post('/penukaran/{id}/reject', [\App\Http\Controllers\Admin\RedemptionController::class, 'reject'])->name('penukaran.reject');
    Route::post('/penukaran/{id}/cancel', [\App\Http\Controllers\Admin\RedemptionController::class, 'cancel'])->name('penukaran.cancel');
    Route::post('/penukaran/{id}/complete', [\App\Http\Controllers\Admin\RedemptionController::class, 'complete'])->name('penukaran.complete');

    // CRUD Reward Items (Barang Penukaran)
    Route::resource('reward-items', \App\Http\Controllers\Admin\RewardItemController::class);
    Route::post('/reward-items/{rewardItem}/update-stock', [\App\Http\Controllers\Admin\RewardItemController::class, 'updateStock'])->name('reward-items.update-stock');
    // Alias route untuk backward compatibility
    Route::get('/tukar-barang', function () {
        return redirect()->route('admin.reward-items.index');
    })->name('tukar-barang');

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
Route::view('/_dev/tukar-barang','admin.tukar_barang.index');
Route::view('/_dev/penukaran','admin.penukaran.index');
Route::view('/_dev/waste-types','admin.waste_types.index');

// Include Auth Routes (Email Verification, Password Reset, etc)
require __DIR__.'/auth.php';
