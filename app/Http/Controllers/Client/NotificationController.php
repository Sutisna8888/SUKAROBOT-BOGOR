<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $notifications = DB::table('notifications')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(15);
        $unreadNotificationCount = DB::table('notifications')
            ->where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return view('client.dashboard.notifications', compact('notifications', 'unreadNotificationCount'));
    }

    public function read(int $id): RedirectResponse
    {
        $notification = DB::table('notifications')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$notification) {
            abort(404);
        }

        DB::table('notifications')
            ->where('id', $id)
            ->update([
                'is_read' => true,
                'updated_at' => now(),
            ]);

        return $notification->link
            ? redirect()->to($notification->link)
            : redirect()->route('client.notifications.index');
    }

    public function readAll(): RedirectResponse
    {
        DB::table('notifications')
            ->where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'updated_at' => now(),
            ]);

        return redirect()->route('client.notifications.index')
            ->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = DB::table('notifications')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('client.notifications.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }
}
