<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\DataSma;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function showLoginForm()
    {
        return view('super_admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Arahkan pengguna berdasarkan peran mereka
            $user = Auth::user();
            if ($user->role === 'super_admin') {
                return redirect()->route('super_admin.dashboard');
            } elseif ($user->role === 'admin_sekolah') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        $total_sekolah = DataSma::count();
        $total_admin = User::where('role', 'admin_sekolah')->count();
        $total_siswa = Siswa::count();

        return view('super_admin.dashboard', compact('total_sekolah', 'total_admin', 'total_siswa'));
    }

    public function createAdminForm()
    {
        $schools = DataSma::doesntHave('admin')->get();
        return view('super_admin.create_admin', compact('schools'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'sma_data_id' => [
                'required',
                'exists:sma_datas,id',
                Rule::unique('users')->where(fn ($query) => $query->where('role', 'admin_sekolah'))
            ],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_sekolah',
            'sma_data_id' => $request->sma_data_id,
        ]);

        return redirect()->route('super_admin.dashboard')->with('success', 'Admin sekolah berhasil dibuat.');
    }
}
