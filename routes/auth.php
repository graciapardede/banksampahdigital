<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Custom Forgot Password Flow
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForm'])
        ->name('password.forgot');

    Route::post('forgot-password/send', [ForgotPasswordController::class, 'sendReset'])
        ->name('password.send-reset');

    Route::get('/verify-reset-code', [ForgotPasswordController::class, 'showVerifyCode'])
        ->name('password.verify-code.form');

    Route::post('/verify-reset-code', [ForgotPasswordController::class, 'verifyCode'])
        ->name('password.verify-code');

    Route::get('reset-password-form', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset-form');

    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.reset');

    // Old routes (fallback)
    Route::get('forgot-password-old', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password-old', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password-old/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset-old');

    Route::post('reset-password-old', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
