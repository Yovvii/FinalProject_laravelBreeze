<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\JalurPendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class AdminSekolahController extends Controller
{
    public function showLoginForm()
    {
        return view('admin_sekolah.login');
    }
    
    public function login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin_sekolah') {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Akun tidak memiliki akses ke admin sekolah.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function dashboard()
    {
        $admin = Auth::user();
        $siswas = collect();
        
        if ($admin->sma_data_id) {
            $siswas = Siswa::with('user', 'DataSma')->whereHas('DataSma', function ($query) use ($admin) {
                $query->where('id', $admin->sma_data_id);
            })->get();
        }
        return view('admin_sekolah.dashboard', compact('siswas'));
    }

    public function showSertifikatMurid()
    {
        $admin = Auth::user();
        $siswas = collect();
        
        if ($admin->sma_data_id) {
            $siswas = Siswa::with('user', 'DataSma')->whereHas('DataSma', function ($query) use ($admin) {
                $query->where('id', $admin->sma_data_id);
            })->whereNotNull('sertifikat_file')->get();
        }
        return view('admin_sekolah.sertifikat_murid', compact('siswas'));
    }
    
    public function verifikasiSertifikat(Request $request, Siswa $siswa)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
        ]);

        $siswa->verifikasi_sertifikat = $request->status;
        $siswa->save();

        return redirect()->back()->with('success', 'Status sertifikat berhasil diperbarui.');
    }

    public function showJalurIndex()
    {
        $firstJalur = JalurPendaftaran::first();
        $jalurs = collect();
        $siswas = collect();

        if ($firstJalur) {
            return Redirect::route('admin.jalur_pendaftaran.show', ['jalur_id' => $firstJalur->id]);
        }
        return view('admin_sekolah.jalur_pendaftaran', compact('jalurs', 'siswas'));
    }

    public function showStudentsByJalur($jalur_id)
    {
        // $siswas = Siswa::whereNotNull('sertifikat_file')->get();
        $admin = Auth::user();
        $siswas = collect();
        $jalurs = JalurPendaftaran::all();
        
        if ($admin->sma_data_id) {
            $query = Siswa::with('user', 'DataSma')->whereHas('DataSma', function ($q) use ($admin) {
                $q->where('id', $admin->sma_data_id);
            })->where('jalur_pendaftaran_id', $jalur_id);

            if ($jalur_id == 1) {
                $query->withSum('semesters', 'nilai_semester');
                $query->orderByDesc('semesters_sum_nilai_semester');
            }

            $siswas = $query->get();
        }
        return view('admin_sekolah.jalur_pendaftaran', compact('siswas', 'jalurs', 'jalur_id'));
    }
}
