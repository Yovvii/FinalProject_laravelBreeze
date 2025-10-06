<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRegistrationStatusAkun
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->siswa && $user->siswa->status_pendaftaran_akun === 'completed') {
            // Jika pendaftaran akun sudah selesai, redirect ke dashboard utama
            return redirect()->route('setelah.dashboard.show');
        }
        return $next($request);
    }
}
