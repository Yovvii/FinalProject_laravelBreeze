<?php

namespace App\Http\Controllers\Auth;

use App\Models\Siswa;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi Input
        $request->validate([
            'nisn' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Cari data siswa berdasarkan NISN
        $siswa = Siswa::where('nisn', $request->nisn)->first();
        if (!$siswa) {
            throw ValidationException::withMessages([
                'nisn' => __('NISN tidak terdaftar.'),
            ]);
        }

        // Ambil data user dari relasi siswa
        $user = $siswa->user;
        if (!$user) {
            throw ValidationException::withMessages([
                'nisn' => __('Akun tidak ditemukan.'),
            ]);
        }

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'nisn' => __('Password salah.'),
            ]);
        }

        // Login user
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
