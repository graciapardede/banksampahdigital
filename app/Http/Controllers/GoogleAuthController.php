<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use GuzzleHttp\Client as GuzzleClient;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user to Google OAuth page
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function handleGoogleCallback()
    {
        try {
            // Get user info from Google with SSL verification disabled (development only)
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new GuzzleClient(['verify' => false]))
                ->user();
            
            // Check if user already exists
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if ($user) {
                // Update existing user's Google token
                $user->update([
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Check if user exists with same email
                $user = User::where('email', $googleUser->getEmail())->first();
                
                if ($user) {
                    // Link Google account to existing user
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                        'avatar' => $googleUser->getAvatar(),
                        'email_verified_at' => now(), // Auto-verify email from Google
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'full_name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                        'avatar' => $googleUser->getAvatar(),
                        'email_verified_at' => now(), // Auto-verify email from Google
                        'password' => Hash::make(Str::random(24)), // Random password
                        'role' => User::ROLE_WARGA, // Default role
                    ]);
                }
            }
            
            // Login user
            Auth::login($user, true);
            
            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard')->with('success', 'Berhasil masuk dengan Google!');
            }
            
            return redirect()->intended('/dashboard')->with('success', 'Berhasil masuk dengan Google!');
            
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            
            return redirect('/login')->with('error', 'Gagal masuk dengan Google. Silakan coba lagi atau gunakan metode login lain.');
        }
    }

    /**
     * Unlink Google account from user
     */
    public function unlinkGoogle(Request $request)
    {
        $user = $request->user();
        
        // Check if user has password (can login without Google)
        if (!$user->password) {
            return back()->with('error', 'Anda harus mengatur password terlebih dahulu sebelum melepas akun Google.');
        }
        
        // Unlink Google account
        $user->update([
            'google_id' => null,
            'google_token' => null,
            'google_refresh_token' => null,
        ]);
        
        return back()->with('success', 'Akun Google berhasil dilepas.');
    }
}
