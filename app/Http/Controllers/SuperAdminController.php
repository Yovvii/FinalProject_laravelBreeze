<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\DataSma;
use App\Models\Akreditasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function dataSma()
    {
        $smas = DataSma::all();
        return view('super_admin.data_sma', compact('smas'));
    }

    public function createSma()
    {
        $akreditasis = Akreditasi::all();
        return view('super_admin.form_sma', compact('akreditasis'));
    }

    public function storeSma(Request $request)
    {
        $validated = $request->validate([
            'nama_sma' => 'required|string|max:255|unique:sma_datas,nama_sma',
            'akreditasi_id' => 'required|exists:akreditasis,id',
            'kuota_siswa' => 'required|integer|min:0',
            'logo_sma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]); 

        $logoPath = null;
        if ($request->hasFile('logo_sma')) {
            $logoPath = $request->file('logo_sma')->store('assets/profile_sekolah_jpg', 'public');
        }

        DataSma::create([
            'nama_sma' => $validated['nama_sma'],
            'akreditasi_id' => $validated['akreditasi_id'],
            'kuota_siswa' => $validated['kuota_siswa'],
            'logo_sma' => $logoPath,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return redirect()->route('super_admin.data_sma')->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    public function editSma(DataSma $sma)
    {
        $akreditasis = Akreditasi::all();
        return view('super_admin.form_sma', compact('sma', 'akreditasis'));
    }

    public function updateSma(Request $request, DataSma $sma)
    {
        $validated = $request->validate([
            'nama_sma' => 'required|string|max:255|unique:sma_datas,nama_sma,' . $sma->id,
            'akreditasi_id' => 'required|exists:akreditasis,id',
            'logo_sma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kuota_siswa' => 'required|integer|min:0', 
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($request->hasFile('logo_sma')) {
            if ($sma->logo_sma) {
                Storage::disk('public')->delete($sma->logo_sma);
            }
            $validated['logo_sma'] = $request->file('logo_sma')->store('assets/profile_sekolah_jpg', 'public');
        }

        $sma->update($validated);

        return redirect()->route('super_admin.data_sma')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    public function destroySma(DataSma $sma)
    {
        if ($sma->siswas()->count() > 0) {
            return redirect()->route('super_admin.data_sma')->with('error', 'Gagal Menghapus! Sekolah ini memiliki ' . $sma->siswas()->count() . ' siswa terdaftar. Hapus data siswa terlebih dahulu');
        }

        if ($sma->logo_sma) {
            Storage::disk('public')->delete($sma->logo_sma);
        }
        $sma->delete();
        return redirect()->route('super_admin.data_sma')->with('success', 'Data sekolah berhasil dihapus.');
    }

    public function dataAdminSekolah()
    {
        $admins = User::where('role', 'admin_sekolah')->with('sma')->get();
        return view('super_admin.data_admin_sma', compact('admins'));
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

    public function editAdminForm(User $admin)
    {
        if ($admin->role !== 'admin_sekolah') {
            return redirect()->route('super_admin.data_admin_sekolah')->with('error', 'Pengguna bukan admin sekolah.');
        }

        $schools = DataSma::doesntHave('admin')
            ->orWhere('id', $admin->sma_data_id)
            ->get();

        return view('super_admin.edit_admin_sma', compact('admin', 'schools'));
    }

    public function updateAdmin(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'sma_data_id' => [
                'required',
                'exists:sma_datas,id',
                Rule::unique('users')->ignore($admin->id)->where(fn ($query) => $query->where('role', 'admin_sekolah'))
            ],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'sma_data_id' => $validated['sma_data_id'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $admin->update($data);

        return redirect()->route('super_admin.data_admin_sekolah')->with('success', 'Data admin sekolah berhasil diperbarui.');
    }

    public function destroyAdmin(User $admin)
    {
        if ($admin->role !== 'admin_sekolah') {
            return redirect()->route('super_admin.data_admin_sekolah')->with('error', 'Hanya admin sekolah yang bisa dihapus.');
        }

        $admin->delete();
        return redirect()->route('super_admin.data_admin_sekolah')->with('success', 'Admin sekolah berhasil dihapus.');
    }
}
