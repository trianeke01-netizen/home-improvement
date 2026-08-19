<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tandai notifikasi tertentu sebagai dibaca
     */
    public function markAsRead($id)
    {
        $notification = AppNotification::where('id_notification', $id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        if ($notification->url) {
            return redirect($notification->url);
        }

        return back()->with('success', 'Notifikasi ditandai dibaca.');
    }

    /**
     * Tandai semua notifikasi pengguna sebagai dibaca
     */
    public function markAllAsRead()
    {
        AppNotification::where('id_user', Auth::user()->id_user)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi berhasil ditandai dibaca.');
    }
}
