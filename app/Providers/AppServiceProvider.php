<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production environment
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // View Composer untuk menyediakan data user dan saldo poin secara global
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Hitung notifikasi yang belum dibaca
                $unreadCount = $user->unreadNotifications()->count();
                
                // Variabel yang tersedia di semua view
                $view->with([
                    'authUser' => $user,
                    'saldoPoin' => $user->balance_points ?? 0,
                    'namaUser' => $user->full_name ?? $user->name ?? 'User',
                    'emailUser' => $user->email ?? '',
                    'roleUser' => $user->role ?? 'user',
                    'unreadNotifications' => $unreadCount,
                ]);
            }
        });
    }
}
