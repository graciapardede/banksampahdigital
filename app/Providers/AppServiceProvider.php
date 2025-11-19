<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        // View Composer untuk menyediakan data user dan saldo poin secara global
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Variabel yang tersedia di semua view
                $view->with([
                    'authUser' => $user,
                    'saldoPoin' => $user->balance_points ?? 0,
                    'namaUser' => $user->full_name ?? $user->name ?? 'User',
                    'emailUser' => $user->email ?? '',
                    'roleUser' => $user->role ?? 'user',
                ]);
            }
        });
    }
}
