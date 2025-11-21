<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page (read-only view)
     */
    public function index(): View
    {
        return view('profil.index', [
            'user' => Auth::user(),
        ]);
    }
    
    /**
     * Show the form for editing profile data
     */
    public function edit(): View
    {
        return view('profil.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = $request->user();
        $user->full_name = $validated['full_name'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && file_exists(public_path('storage/profile_photos/' . $user->profile_photo))) {
                unlink(public_path('storage/profile_photos/' . $user->profile_photo));
            }

            // Store new photo
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/profile_photos'), $filename);
            $user->profile_photo = $filename;
        }

        $user->save();

        return Redirect::route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo) {
            // Delete photo file
            $photoPath = public_path('storage/profile_photos/' . $user->profile_photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }

            // Update database
            $user->profile_photo = null;
            $user->save();

            return back()->with('success', 'Foto profil berhasil dihapus!');
        }

        return back()->with('error', 'Tidak ada foto profil untuk dihapus.');
    }

    /**
     * Show the form for changing password
     */
    public function editPassword(): View
    {
        return view('profil.password', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $request->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        // Update password
        $user = $request->user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return Redirect::route('profil.index')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
