<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoBrowserCache
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini memaksa browser untuk TIDAK meng-cache response.
     * Digunakan untuk halaman yang membutuhkan data real-time seperti:
     * - Dashboard Warga (saldo poin, status setoran)
     * - Riwayat transaksi
     * 
     * Mencegah bug "Stale Data" dimana Admin sudah verifikasi setoran,
     * tapi Warga masih melihat status lama karena browser cache.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Proses request dulu
        $response = $next($request);

        // Tambahkan HTTP Headers untuk menonaktifkan browser cache
        return $response
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Cache-Control', 'post-check=0, pre-check=0', false)
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT'); // Tanggal di masa lalu
    }
}
