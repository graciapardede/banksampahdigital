<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        
        // Mark all unread notifications as read when viewing
        $user->unreadNotifications->markAsRead();
        
        $notifications = $user->notifications()
            ->latest()
            ->get();

        // Jika admin, gunakan view admin
        if ($user->role === 'admin') {
            return view('admin.notifikasi', compact('notifications'));
        }

        // Jika user biasa, gunakan view user
        return view('notifikasi', compact('notifications'));
    }

    /**
     * Mark a specific notification as read and redirect to link
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        // Redirect ke link notifikasi atau ke halaman notifikasi
        $link = $notification->data['link'] ?? route('notifikasi');
        
        return redirect($link);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json([
            'message' => 'Semua notifikasi ditandai sudah dibaca'
        ]);
    }

    /**
     * Get unread notification count
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();

        return response()->json([
            'count' => $count
        ]);
    }
}
