<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form lupa password
     */
    public function showForm()
    {
        return view('auth.forgot-password-custom');
    }

    /**
     * Verifikasi email & kirim kode reset
     */
    public function sendReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak ditemukan di sistem.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate kode reset (6 digit)
        $resetCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan kode reset (valid 15 menit)
        $user->update([
            'password_reset_code' => $resetCode,
            'password_reset_expires_at' => now()->addMinutes(15),
        ]);

        // Log kode reset (untuk dev)
        \Log::info("Password reset code for {$user->email}: {$resetCode}");

        // Kirim email dengan kode reset
        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, $resetCode));
            $message = "Kode reset telah dikirim ke email Anda ({$user->email}).";
        } catch (\Exception $e) {
            \Log::error("Failed to send password reset email: " . $e->getMessage());
            $message = "Periksa email Anda untuk menerima kode reset.";
        }

        return redirect()->route('password.verify-code')
            ->with('email', $user->email)
            ->with('success', $message);
    }

    /**
     * Tampilkan form verifikasi kode
     */
    public function showVerifyCode(Request $request)
    {
        return view('auth.verify-reset-code', ['email' => $request->query('email')]);
    }

    /**
     * Verifikasi kode reset
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'reset_code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek kode
        if (
            !$user->password_reset_code ||
            $user->password_reset_code !== $request->reset_code ||
            $user->password_reset_expires_at < now()
        ) {
            return back()
                ->withInput()
                ->with('error', 'Kode reset tidak valid atau sudah expired.');
        }

        // Kode valid, redirect ke form reset password
        return redirect()->route('password.reset-form')
            ->with('email', $user->email)
            ->with('reset_code', $request->reset_code)
            ->with('success', 'Kode terverifikasi. Silakan atur password baru.');
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password-custom', [
            'email' => $request->query('email'),
            'reset_code' => $request->query('reset_code'),
        ]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'reset_code' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        // Verifikasi ulang kode
        if (
            !$user->password_reset_code ||
            $user->password_reset_code !== $request->reset_code ||
            $user->password_reset_expires_at < now()
        ) {
            return back()
                ->with('error', 'Kode reset tidak valid atau sudah expired. Silakan mulai dari awal.');
        }

        // Update password & clear kode reset
        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_code' => null,
            'password_reset_expires_at' => null,
        ]);

        return redirect()->route('login')
            ->with('status', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}
