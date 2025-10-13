<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika sudah login DAN perannya adalah 'super_admin'
        if (Auth::check() && Auth::user()->role === 'super_admin') {
            return $next($request);
        }
        
        // 💡 PERBAIKAN: Jika bukan Super Admin (atau belum login), redirect ke landing page.
        // Asumsi: redirect('') yang Anda berikan maksudnya redirect('/')
        return redirect('/')->with('error', 'Akses ditolak. Anda bukan Super Admin.');
        // Atau: return redirect()->route('landing_page')->with('error', 'Akses ditolak. Anda bukan Super Admin.');
    }
}
