<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new warga user and log them in.
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['full_name'], // Fill both name and full_name
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_WARGA,
            'balance_points' => 0,
        ]);

        Auth::login($user);

        // Redirect based on role
        if ($user->isWarga()) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->intended('/admin');
    }

    /**
     * Login existing user.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isWarga()) {
                return redirect()->intended('/dashboard');
            }

            return redirect()->intended('/admin');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    /**
     * Logout the current user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Return the authenticated user's profile (JSON).
     */
    public function getProfile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Update the authenticated user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (isset($validated['password']) && $validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        foreach (['full_name', 'email', 'phone', 'address'] as $field) {
            if (array_key_exists($field, $validated)) {
                $user->{$field} = $validated[$field];
            }
        }

        $user->save();

        return response()->json($user);
    }
}
