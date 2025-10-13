<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DataSma;
use App\Models\SpmbStatus;
use Illuminate\Http\Request;
use App\Models\JalurPendaftaran;
use App\Traits\LogsStudentActions;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class AdminSekolahController extends Controller
{
    private const KUOTA_PERSEN = [
        '1' => 0.15, // 15% (Jalur 1)
        '2' => 0.25, // 25% (Jalur 2)
        '3' => 0.60, // 60% (Jalur 3 / Zonasi)
    ];
    use LogsStudentActions;
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
        $total_siswa = 0;
        $total_prestasi = 0; 
        $total_afirmasi = 0;
        $total_zonasi = 0;
        $total_ditolak_sertifikat = 0;
        $total_ditolak_afirmasi = 0; 
        
        if ($admin->sma_data_id) {
            $siswas = Siswa::with('user', 'DataSma')->whereHas('DataSma', function ($query) use ($admin) {
                $query->where('id', $admin->sma_data_id);
            })->get();

            $total_siswa = $siswas->count();
        
            $total_prestasi = $siswas->where('jalur_pendaftaran_id', 1)->count();
            $total_afirmasi = $siswas->where('jalur_pendaftaran_id', 2)->count();
            $total_zonasi = $siswas->where('jalur_pendaftaran_id', 3)->count();

            $total_ditolak_sertifikat = $siswas->where('verifikasi_sertifikat', 'ditolak')->count();
            $total_ditolak_afirmasi = $siswas->where('verifikasi_afirmasi', 'ditolak')->count();
        }
        return view('admin_sekolah.dashboard', compact('siswas', 'total_siswa', 'total_prestasi', 'total_afirmasi', 'total_zonasi', 'total_ditolak_sertifikat', 'total_ditolak_afirmasi'));
    }
    
    public function showStudentsByJalur($jalur_id)
    {
        $admin = Auth::user();
        $siswas = collect();
        $jalurs = JalurPendaftaran::all();
        $spmb_status = SpmbStatus::first();
        $selection_ended = ($spmb_status && $spmb_status->status === 'closed');
        
        if ($admin->sma_data_id) {
            $baseQuery = Siswa::whereHas('DataSma', function ($q) use ($admin) {
                $q->where('id', $admin->sma_data_id);
            })->where('jalur_pendaftaran_id', $jalur_id);

            if ($jalur_id == 1) {
                $subQueryNilai = "(SELECT SUM(semesters.nilai_semester) FROM semesters WHERE siswas.user_id = semesters.user_id)";
                $selectStatement = '
                    siswas.*,
                    ('. $subQueryNilai .') AS total_nilai_semester,
                    CASE 
                        WHEN verifikasi_sertifikat = "terverifikasi" THEN 1 
                        ELSE 0 
                    END as verification_priority
                ';
                $baseQuery->select(DB::raw($selectStatement));
                $baseQuery->orderByDesc('verification_priority');
                $baseQuery->orderByDesc('total_nilai_semester');
            }
            
            $siswas = $baseQuery->with('user', 'DataSma')->get();

            if ($jalur_id == 2) {
                // Ambil koordinat SMA milik admin
                $dataSma = \App\Models\DataSma::find($admin->sma_data_id);
                $latSma = $dataSma->latitude ?? 0;
                $lngSma = $dataSma->longitude ?? 0;
                
                
                // Loop untuk menghitung jarak dan menambahkan properti
                foreach ($siswas as $siswa) {
                    // Gunakan properti jarak yang sudah disimpan saat pendaftaran (jika ada)
                    if ($siswa->jarak_ke_sma_km) {
                        $siswa->jarak_ke_sekolah = $siswa->jarak_ke_sma_km;
                    } elseif ($siswa->latitude_siswa && $siswa->longitude_siswa) {
                        // Jika belum tersimpan (misal data lama), hitung ulang
                        $jarak = $this->calculateDistance($latSma, $lngSma, $siswa->latitude_siswa, $siswa->longitude_siswa);
                        $siswa->jarak_ke_sekolah = round($jarak, 2);
                    } else {
                        // Tetapkan nilai sangat besar untuk data tanpa koordinat agar ditaruh di akhir
                        $siswa->jarak_ke_sekolah = 99999.99; 
                    }
                }

                $siswas = $siswas->sortBy('jarak_ke_sekolah')->values();
                
                // Kembalikan placeholder menjadi 'N/A' untuk tampilan
                foreach ($siswas as $siswa) {
                    if ($siswa->jarak_ke_sekolah == 99999.99) {
                        $siswa->jarak_ke_sekolah = 'N/A';
                    }
                }
            }
        }
        
        return view('admin_sekolah.jalur_pendaftaran', compact('siswas', 'jalurs', 'jalur_id', 'selection_ended'));
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
    
    public function verifikasiSertifikat(Request $request, Siswa $siswa)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak,pending',
        ]);
        
        $siswa->verifikasi_sertifikat = $request->status;
        $siswa->save();
        
        $notificationMessage = '';
        $notificationType = '';
        $flashMessage = '';

        if ($request->status === 'terverifikasi') {
            $notificationMessage = 'Selamat! Dokumen sertifikat Anda untuk jalur prestasi telah Terverifikasi oleh Admin Sekolah.';
            $notificationType = 'success';
            $flashMessage = 'Status sertifikat berhasil Diverifikasi.';
        } elseif ($request->status === 'ditolak') {
            $notificationMessage = 'Mohon maaf, dokumen sertifikat Anda untuk jalur prestasi telah Ditolak oleh Admin Sekolah. Peringkat akan disesuaikan dengan Nilai Akhir, atau anda juga bisa melakukan pendaftaran ulang';
            $notificationType = 'error';
            $flashMessage = 'Status sertifikat berhasil Ditolak.';
        } else {
            // Kasus 'pending' atau status lain (opsional, bisa dihilangkan jika tidak perlu notifikasi)
            $notificationMessage = 'Status dokumen sertifikat Anda diubah menjadi **PENDING** oleh Admin Sekolah.';
            $notificationType = 'info';
            $flashMessage = 'Status sertifikat berhasil diperbarui menjadi PENDING.';
        }
        
        // Simpan notifikasi ke NotificationHistory
        NotificationHistory::create([
            // User ID yang menerima notifikasi (ID siswa)
            'user_id' => $siswa->user_id, 
            'type' => $notificationType,
            'message' => $notificationMessage,
            'is_read' => false,
            'created_by_user_id' => Auth::id(), 
        ]);
        
        return redirect()->back()->with('success', $flashMessage);
    }

    public function verifikasiAfirmasi(Request $request, Siswa $siswa)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak,pending',
        ]);

        $siswa->verifikasi_afirmasi = $request->status;
        $siswa->save();

        $notificationMessage = '';
        $notificationType = '';
        $flashMessage = '';

        if ($request->status === 'terverifikasi') {
            $notificationMessage = 'Selamat! Dokumen afirmasi Anda untuk jalur afirmasi telah Terverifikasi.';
            $notificationType = 'success';
            $flashMessage = 'Status dokumen afirmasi Terverifikasi.';
        } elseif ($request->status === 'ditolak') {
            $notificationMessage = 'Mohon maaf, dokumen afirmasi Anda untuk jalur afirmasi telah Ditolak oleh Admin Sekolah. Silakan lakukan pendaftaran ulang';
            $notificationType = 'error';
            $flashMessage = 'Status dokumen afirmasi Ditolak.';
        } else {
            // Kasus 'pending'
            $notificationMessage = 'Status dokumen afirmasi Anda diubah menjadi **PENDING** oleh Admin Sekolah.';
            $notificationType = 'info';
            $flashMessage = 'Status dokumen afirmasi berhasil diperbarui menjadi PENDING.';
        }

        // Simpan notifikasi ke NotificationHistory
        // User ID penerima notifikasi adalah user_id dari siswa yang diverifikasi
        NotificationHistory::create([
            'user_id' => $siswa->user_id, 
            'type' => $notificationType,
            'message' => $notificationMessage,
            'is_read' => false,
            'created_by_user_id' => Auth::id(), // Opsional: Mencatat Admin yang melakukan tindakan
        ]);

        return redirect()->back()->with('success', $flashMessage);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2) 
    {
        // Konstanta Jari-jari Bumi dalam Kilometer
        $earthRadius = 6371; 

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Jarak dalam KM

        return $distance;
    }

    public function indexPeringkatMurid()
    {
        $firstJalur = JalurPendaftaran::first();
        $jalurs = collect();
        $siswas = collect();

        if ($firstJalur) {
            return Redirect::route('admin.peringkat_murid.show', ['jalur_id' => $firstJalur->id]);
        }
        return view('admin_sekolah.peringkat_murid');
    }

    public function showPeringkatMurid($jalur_id)
    {
        $admin = Auth::user();
        $sma_id = $admin->sma_data_id;
        $jalurs = JalurPendaftaran::all();
        $siswas = collect();
        $ppdb_status = SpmbStatus::first();
        $selection_ended = ($ppdb_status && $ppdb_status->status === 'closed');

        $kuotaJalur = 0;
        if ($sma_id) {
            // 1. Ambil Data SMA
            $smaData = DataSma::find($sma_id);
            $totalKuotaSekolah = $smaData->kuota_siswa ?? 0;
            
            // 2. Hitung Kuota Jalur Berdasarkan Persentase
            $persentase = self::KUOTA_PERSEN[$jalur_id] ?? 0;
            $kuotaJalur = (int) floor($totalKuotaSekolah * $persentase); // Cast ke integer
            // dd(['ID SMA' => $sma_id, 'Kuota Total DB' => $totalKuotaSekolah, 'Jalur ID' => $jalur_id, 'Persen' => $persentase, 'Kuota Jalur Final' => $kuotaJalur]);
        }

        if ($sma_id) {
            $query = Siswa::with('user', 'sekolahAsal')
                ->where('data_sma_id', $sma_id)
                ->where('jalur_pendaftaran_id', $jalur_id);

            if ($jalur_id == 1) {
                $query->orderBy(DB::raw("CASE 
                    WHEN verifikasi_sertifikat = 'terverifikasi' THEN 1 
                    ELSE 0 
                END"), 'desc')->orderByDesc('nilai_akhir')->orderBy('tanggal_lahir', 'asc');                
            } elseif ($jalur_id == 2) { 
                $query->where('verifikasi_afirmasi', 'terverifikasi');
                $siswas = $query->orderBy('jarak_ke_sma_km')->orderBy('tanggal_lahir', 'asc');
            } elseif ($jalur_id == 3) {
                $query->orderBy('jarak_ke_sma_km')->orderBy('tanggal_lahir', 'asc');
            }else {
                $siswas = $query->orderByDesc('nilai_akhir')->orderBy('tanggal_lahir');
            }
            if ($selection_ended) {
                // Jika seleksi selesai, batasi hasil hanya sejumlah kuota yang tersedia
                $query->limit($kuotaJalur);
            }
            $siswas = $query->get();
        }
        
        return view('admin_sekolah.peringkat_murid', compact('siswas', 'jalurs', 'jalur_id', 'selection_ended', 'kuotaJalur'));
    }
}
