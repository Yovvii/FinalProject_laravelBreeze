<?php

namespace App\Traits;

use App\Models\NotificationHistory;
use Illuminate\Support\Facades\Auth;

trait LogsStudentActions
{
    /**
     * Mencatat pesan ke database dan melakukan pengalihan dengan flash message.
     * @param string $route Nama rute tujuan.
     * @param string $type 'success' atau 'error'
     * @param string $message Pesan notifikasi
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function logAndRedirect($route, $type, $message)
    {
        if (Auth::check()) {
            NotificationHistory::create([
                'user_id' => Auth::id(),
                'type' => $type,
                'message' => $message,
            ]);
        }
        
        // Flash ke Session untuk tampilan banner notifikasi
        return redirect()->route($route)->with($type, $message);
    }
    
    /**
     * Mencatat pesan dan kembali ke halaman sebelumnya (untuk error atau back).
     */
    protected function logAndBack($type, $message)
    {
        if (Auth::check()) {
            NotificationHistory::create([
                'user_id' => Auth::id(),
                'type' => $type,
                'message' => $message,
            ]);
        }
        return back()->with($type, $message);
    }
}