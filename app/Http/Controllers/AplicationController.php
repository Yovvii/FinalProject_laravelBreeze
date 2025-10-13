<?php

namespace App\Http\Controllers;

use App\Models\SpmbStatus;
use Illuminate\Http\Request;
use App\Models\NotificationHistory;
use Illuminate\Support\Facades\Auth;

class AplicationController extends Controller
{
    protected function isSelectionEnded()
    {
        $ppdb_status = SpmbStatus::first(); 
        return ($ppdb_status && $ppdb_status->status === 'closed');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Ambil riwayat notifikasi 
        $notifications = NotificationHistory::where('user_id', $user->id)
                                         ->orderByDesc('created_at', 'desc')
                                         ->limit(50) // Hanya tampilkan 50 notifikasi terbaru
                                         ->get();

        NotificationHistory::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
                                         
        return view('notification_siswa', compact('notifications'));
    }

    public function destroy(NotificationHistory $notification)
    {
        // Pastikan notifikasi ini milik user yang sedang login
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        return redirect()->route('notification.index')->with('success', 'Pemberitahuan berhasil dihapus.');
    }

    /**
     * Menghapus semua notifikasi milik user.
     */
    public function clearAll()
    {
        NotificationHistory::where('user_id', Auth::id())->delete();

        return redirect()->route('notification.index')->with('success', 'Semua pemberitahuan berhasil dibersihkan.');
    }

    public function markAllAsRead()
    {
        NotificationHistory::where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return redirect()->route('notification.index')->with('success', 'Semua pemberitahuan berhasil ditandai sudah dibaca.');
    }

    public static function unreadCount() // <-- PASTIKAN ADA public static
    {
        if (Auth::check()) {
            return NotificationHistory::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();
        }
        return 0;
    }
}
