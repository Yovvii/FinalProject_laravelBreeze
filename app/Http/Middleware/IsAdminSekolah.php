<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminSekolah
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika sudah login DAN perannya adalah 'admin_sekolah'
        if (Auth::check() && Auth::user()->role === 'admin_sekolah') {
            return $next($request);
        }
        
        // 💡 PERBAIKAN: Jika bukan Admin Sekolah, redirect ke landing page
        return redirect('/')->with('error', 'Akses ditolak. Anda bukan Admin Sekolah.');
        // Atau: return redirect()->route('landing_page')->with('error', 'Akses ditolak. Anda bukan Admin Sekolah.');
    }
}