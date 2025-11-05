<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Halaman Dashboard User (Warga)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route untuk user biasa (warga)
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

// Penting: letakkan selalu di luar grup manapun
require __DIR__.'/auth.php';
