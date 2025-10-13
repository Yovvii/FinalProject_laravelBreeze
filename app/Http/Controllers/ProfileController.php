<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Semester;
use App\Models\RaporFile;
use App\Models\SekolahAsal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\LogsStudentActions;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\Siswa; // Pastikan Siswa di-import
use App\Models\User; // Pastikan Siswa di-import

class ProfileController extends Controller
{
    use LogsStudentActions;

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        // 1. Verifikasi Password Lama
        if (!Hash::check($request->current_password, $user->password)) {
            // Jika password lama salah, throw exception
            throw ValidationException::withMessages([
                'current_password' => 'Password lama yang Anda masukkan salah.',
            ]);
        }
        
        // 2. Update Password Baru
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(), // Catat waktu perubahan
        ]);

        // NotificationHistory::create([
        //     'user_id' => $user->id,
        //     'type' => 'success',
        //     'message' => 'Password berhasil diperbaharui',
        //     'is_read' => false,
        // ]);
        
        // 3. Pencatatan Notifikasi
        // Menggunakan Trait logAndRedirect untuk mencatat aksi update password
        return $this->logAndRedirect('dashboard', 'success', 'Password Anda berhasil diperbarui. Pastikan Anda mengingatnya!');
    }

    public function showSettings()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Memuat relasi siswa (jika belum ada, buat objek siswa kosong sementara)
        $siswa = $user->siswa ?? new Siswa();
        
        // Memastikan relasi siswa dimuat (terutama untuk foto)
        $user->load('siswa'); 
        $isRegistered = !is_null($siswa->data_sma_id);
        
        // Periksa apakah siswa memiliki NISN (indikator data pendaftaran sudah dimulai)
        if (empty($siswa->nisn) && $siswa->exists) {
            // Opsional: Tangani jika data pendaftaran belum dimulai
            // return redirect()->route('dashboard')->with('error', 'Silakan lengkapi pendaftaran.');
        }

        // Mengembalikan view standalone
        return view('profile.setting_profile', compact('user', 'siswa', 'isRegistered'));
    }

    public function editBiodata()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Memuat relasi siswa dan ortu
        $user->load('siswa.ortu'); 
        
        $siswa = $user->siswa;
        $ortu = $siswa->ortu ?? null;
        $sekolahAsals = SekolahAsal::all(); 

        // Jika Anda menggunakan data sekolah asal/lainnya, muat di sini
        // $sekolahAsals = \App\Models\SekolahAsal::all(); 
        NotificationHistory::create([
            'user_id' => $user->id,
            'type' => 'success',
            'message' => 'Biodata berhasil diperbaharui',
            'is_read' => false,
        ]);

        // Mengembalikan view standalone untuk edit biodata
        return view('profile.edit_biodata', compact('user', 'siswa', 'ortu', 'sekolahAsals'))->with('success', 'Biodata Berhasil Diperbaharui!');
    }


    public function updateBiodata(Request $request)
    {
        // Menggunakan logika validasi yang sama
        $validatedData = $request->validate([
            // file
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'akta_file' => 'nullable|file|mimes:pdf|max:2048',

            // data siswa (pastikan nama input sesuai dengan nama kolom DB yang akan diisi)
            'jenis_kelamin' => 'nullable|string',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_kk' => 'nullable|string',
            'nik' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'email' => 'nullable|string',
            'agama' => 'nullable|string',
            'kebutuhan_k' => 'nullable|string',
            'sekolah_asal_id' => 'nullable|integer',
            'latitude' => 'required|numeric', // Nama input di form
            'longitude' => 'required|numeric', // Nama input di form
            
            // data wali
            'nama_wali' => 'nullable|string|max:255',
            'tempat_lahir_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'alamat_wali' => 'nullable|string|max:255',
        ]);

        // Menggunakan DB::transaction untuk keamanan data
        DB::transaction(function () use ($validatedData, $request) {
            $user = Auth::user();
            $siswa = $user->siswa; // Di halaman ini, siswa PASTI sudah ada

            // Update email user
            $user->email = $validatedData['email'];
            $user->save();

            // Logika upload file (sama seperti di SmaController)
            if ($request->hasFile('foto')) {
                if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                $siswa->foto = $request->file('foto')->store('profile_murid', 'public');
            }
            if ($request->hasFile('akta_file')) {
                if ($siswa->akta_file && Storage::disk('public')->exists($siswa->akta_file)) {
                    Storage::disk('public')->delete($siswa->akta_file);
                }
                $siswa->akta_file = $request->file('akta_file')->store('akta_murid', 'public');
            }
            
            // Mempersiapkan data siswa untuk mass assignment
            $siswaData = collect($validatedData)->except([
                'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'pekerjaan_wali', 'alamat_wali', 'foto', 'akta_file', 'email'
            ])->toArray();

            // Mengisi data siswa non-koordinat
            $siswa->fill($siswaData);
            
            // Pengisian eksplisit untuk kolom koordinat
            $siswa->latitude_siswa = $validatedData['latitude'];
            $siswa->longitude_siswa = $validatedData['longitude'];

            // Menyimpan data siswa
            $siswa->save();

            // Menyimpan data Ortu
            $ortuData = $request->only([
                'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'pekerjaan_wali', 'alamat_wali'
            ]);

            Ortu::updateOrCreate(
                ['siswa_id' => $siswa->id],
                $ortuData
            );
        });

        // Redirect kembali ke halaman setting profile setelah berhasil
        return redirect()->route('profile.settings')->with('success', 'Biodata berhasil diperbarui!');
    }

    public function editNilai()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // 💡 PERBAIKAN: Memuat 'semesters' dan 'raporFiles' langsung dari model User.
        // Memuat: Siswa, data Nilai (semesters), dan File Rapor (raporFiles)
        $user->load('siswa', 'semesters', 'raporFiles'); 
        
        $siswa = $user->siswa;
        // Data nilai yang sudah ada diakses dari relasi User
        $semesters = $user->semesters ?? collect(); 
        $raporFiles = $user->raporFiles ?? collect(); 
        
        $mapels = \App\Models\Mapel::all(); 
        $allSemesters = \App\Models\Semester::all(); 

        // Mengembalikan view standalone untuk edit nilai
        return view('profile.edit_nilai', compact('user', 'siswa', 'mapels', 'semesters', 'allSemesters', 'raporFiles'));
    }

    public function updateNilai(Request $request)
    {
        try {
            $userId = Auth::id();
            $dataNilai = $request->input('nilai', []);
            
            // 1. Ambil file rapor yang sudah ada di database
            // Mengikuti struktur DB Anda: RaporFile menggunakan kolom 'semester'
            $existingRaporFiles = RaporFile::where('user_id', $userId)
                                        ->pluck('file_rapor', 'semester'); 

            // 2. Tentukan aturan dasar untuk file dan non-file
            $baseRules = [
                'nilai' => 'required|array', // Harus ada input nilai
                'rapor_file' => 'nullable|array',
            ];
            $fileBaseRules = 'mimes:pdf|max:1000'; // Maksimal 1MB

            // 3. Bangun aturan validasi nilai dan file secara dinamis
            foreach ($dataNilai as $semester => $nilaiMapel) {
                
                // Aturan untuk nilai: nullable (boleh kosong), numeric, max 100
                foreach ($nilaiMapel as $mapelKey => $nilai) {
                    $baseRules["nilai.{$semester}.{$mapelKey}"] = 'nullable|numeric|min:0|max:100';
                }

                // Aturan untuk file
                $fileKey = "rapor_file.{$semester}";
                
                // Cek apakah file untuk semester ini sudah ada (menggunakan string key karena pluck mengembalikan string)
                $isFileExists = $existingRaporFiles->has((string)$semester) && !empty($existingRaporFiles[(string)$semester]);
                
                if ($isFileExists) {
                    // Jika sudah ada, upload file baru bersifat opsional
                    $baseRules[$fileKey] = 'nullable|' . $fileBaseRules;
                } else {
                    // Jika belum ada, upload file baru wajib (required)
                    $baseRules[$fileKey] = 'required|' . $fileBaseRules;
                }
            }

            // 4. Lakukan validasi
            $validated = $request->validate($baseRules);

            // --- Logika Penyimpanan Data ---
            
            DB::beginTransaction();

            $dataNilai = $validated['nilai'];
            $mapels = Mapel::all();
            
            // Looping penyimpanan data nilai dan file
            foreach ($dataNilai as $semester => $nilaiMapel) {
                
                // A. LOGIKA PENYIMPANAN FILE RAPOR
                if ($request->hasFile("rapor_file.{$semester}")) {
                    $file = $request->file("rapor_file.{$semester}");

                    $existingRaporFile = RaporFile::where('user_id', $userId)->where('semester', $semester)->first();

                    // Logika menghapus file lama
                    if ($existingRaporFile && $existingRaporFile->file_rapor && Storage::disk('public')->exists($existingRaporFile->file_rapor)) {
                        Storage::disk('public')->delete($existingRaporFile->file_rapor); 
                    }
                    
                    // Simpan file baru dan dapatkan path-nya
                    $path = $file->store('rapor_murid/' . $userId, 'public'); 

                    // Simpan path penuh (relatif ke disk 'public') ke database
                    RaporFile::updateOrCreate(
                        ['user_id' => $userId,
                        'semester' => $semester],
                        ['file_rapor' => $path] 
                    );
                }
                
                // B. LOGIKA PENYIMPANAN NILAI
                foreach ($nilaiMapel as $namaMapel => $nilai) {
                    $namaMapelDariForm = Str::replace('_', ' ', $namaMapel);

                    // Mencari Mapel ID
                    $mapelId = $mapels->firstWhere(function ($mapel) use ($namaMapelDariForm) {
                        return Str::lower($mapel->nama_mapel) === Str::lower($namaMapelDariForm);
                    })->id ?? null;

                    if ($nilai !== null && $mapelId !== null) {
                        // ASUMSI: Model Semester adalah tempat penyimpanan nilai siswa (terhubung ke user_id, mapel_id, semester)
                        Semester::updateOrCreate(
                            ['user_id' => $userId,
                            'mapel_id' => $mapelId,
                            'semester' => $semester],
                            ['nilai_semester' => $nilai]
                        );
                    }
                }
            }

            DB::commit();

            NotificationHistory::create([
                'user_id' => Auth::user()->id,
                'type' => 'success',
                'message' => 'Data nilai berhasil diperbaharui',
                'is_read' => false,
            ]);

            // 💡 Ganti redirect()->back() menjadi redirect ke halaman setting profile
            return redirect()->route('profile.settings')->with('success', 'Data Nilai berhasil diperbarui!');

        } catch (ValidationException $e) {
            DB::rollBack();
            // Redirect kembali ke form dengan pesan error dan input lama (old input)
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan rapor di ProfileController: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            NotificationHistory::create([
                'user_id' => Auth::user()->id,
                'type' => 'error',
                'message' => 'Data nilai rapor gagal diperbaharui, silahan coba lagi',
                'is_read' => false,
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    // Fungsi bantu untuk mengelola file upload rapor
    private function handleRaporFileUpload(Request $request, $user, $inputName, $semesterId)
    {   
        if ($request->hasFile($inputName)) {
            // (RaporFile model harus di-import: use App\Models\RaporFile;)
            $RaporFileModel = \App\Models\RaporFile::class;

            // Mencari atau membuat data file berdasarkan user_id dan semester_id
            $raporFile = $RaporFileModel::firstOrNew([
                'user_id' => $user->id, // 💡 Menggunakan user_id
                'semester_id' => $semesterId
            ]);

            // Hapus file lama jika ada
            if ($raporFile->file_path && Storage::disk('public')->exists($raporFile->file_path)) {
                Storage::disk('public')->delete($raporFile->file_path);
            }

            // Simpan file baru
            $raporFile->file_path = $request->file($inputName)->store('rapor_murid', 'public');
            $raporFile->save();
        }
    }

    public function editDokumen()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Muat relasi siswa karena file disimpan di model Siswa
        $user->load('siswa'); 
        $siswa = $user->siswa;

        // Mengembalikan view standalone untuk edit dokumen
        return view('profile.edit_dokumen', compact('user', 'siswa'));
    }

    // --- Fungsi untuk menyimpan (menggabungkan _saveSuratPernyataan & _saveSuratKeteranganLulus) ---
    public function updateDokumen(Request $request)
    {
        // 1. Validasi Gabungan untuk ketiga file
        $validated = $request->validate([
            'surat_pernyataan' => 'nullable|file|mimes:pdf|max:2048',
            'surat_keterangan_lulus' => 'nullable|file|mimes:pdf|max:2048',
            'ijazah_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // 2. Logika Penyimpanan dalam Transaksi
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $siswa = $user->siswa;

            // --- Logika untuk Surat Pernyataan ---
            if ($request->hasFile('surat_pernyataan')) {
                if ($siswa->surat_pernyataan && Storage::disk('public')->exists($siswa->surat_pernyataan)) {
                    Storage::disk('public')->delete($siswa->surat_pernyataan);
                }
                $siswa->surat_pernyataan = $request->file('surat_pernyataan')->store('surat_pernyataan', 'public');
            }

            // --- Logika untuk Surat Keterangan Lulus (SKL) ---
            if ($request->hasFile('surat_keterangan_lulus')) {
                if ($siswa->surat_keterangan_lulus && Storage::disk('public')->exists($siswa->surat_keterangan_lulus)) {
                    Storage::disk('public')->delete($siswa->surat_keterangan_lulus);
                }
                $siswa->surat_keterangan_lulus = $request->file('surat_keterangan_lulus')->store('surat_keterangan_lulus', 'public');
            }

            // --- Logika untuk Ijazah ---
            if ($request->hasFile('ijazah_file')) {
                if ($siswa->ijazah_file && Storage::disk('public')->exists($siswa->ijazah_file)) {
                    Storage::disk('public')->delete($siswa->ijazah_file);
                }
                $siswa->ijazah_file = $request->file('ijazah_file')->store('ijazah_file', 'public');
            }

            // Simpan semua perubahan pada model Siswa
            // Catatan: Logika status_pendaftaran_akun dihapus karena ini halaman edit, bukan pendaftaran awal
            $siswa->save();
        });

        NotificationHistory::create([
            'user_id' => Auth::user()->id,
            'type' => 'success',
            'message' => 'Dokumen berhasil diperbaharui',
            'is_read' => false,
        ]);

        // 3. Redirect ke halaman pengaturan profil
        return redirect()->route('profile.settings')->with('success', 'Dokumen berhasil diperbarui!');
    }
    private function checkRegistrationAndRedirect($siswa)
    {
        // Cek apakah siswa sudah terdaftar
        if (!is_null($siswa->sekolah_id)) { // Ganti 'sekolah_id' dengan kolom yang benar
            return redirect()->route('profile.settings')->with('error', 'Aksi ditolak: Data tidak bisa diubah/direset karena Anda sudah terdaftar di sekolah.');
        }
        return null; // Lanjutkan jika belum terdaftar
    }

    public function resetBiodata()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        $check = $this->checkRegistrationAndRedirect($siswa);
        if ($check) return $check;

        try {
            DB::transaction(function () use ($siswa, $user) {
                
                // 1. Reset data Siswa (Kolom biodata selain data dasar NISN/Nama)
                $user->name = $user->name; // Biarkan nama tetap ada
                $user->email = null;
                $user->save();

                // 2. Hapus data Ortu/Wali (jika ada)
                // Asumsi: Relasi Ortu menangani data ayah, ibu, dan wali
                if ($siswa->ortu) {
                    $siswa->ortu->delete();
                }

                // 3. Reset data di tabel siswas
                // Kita setel NULL untuk semua kolom non-wajib yang diisi user
                
                // Kolom Data Siswa
                $siswa->jenis_kelamin = null;
                $siswa->kabupaten = null;
                $siswa->kecamatan = null;
                $siswa->desa = null; // Dulu 'kelurahan', sekarang 'desa'
                $siswa->alamat = null;
                $siswa->no_kk = null;
                $siswa->nik = null;
                $siswa->no_hp = null;
                $siswa->agama = null;
                $siswa->kebutuhan_k = null;
                $siswa->sekolah_asal_id = null;
                $siswa->latitude_siswa = null; // Menghapus map/koordinat
                $siswa->longitude_siswa = null; // Menghapus map/koordinat
                $siswa->nama_ayah = null;
                $siswa->nama_ibu = null;
                
                // Kolom File (Aksi hapus file di storage dilakukan di resetDokumen)
                $siswa->foto = null; 
                $siswa->akta_file = null; 
                
                // Kolom Status (Reset ke status awal)
                $siswa->status_pendaftaran = 'pending';
                $siswa->data_sma_id = null; // Opsional: Hapus pilihan SMA
                $siswa->jalur_pendaftaran_id = null; // Opsional: Hapus pilihan Jalur
                
                $siswa->save();

            });

            NotificationHistory::create([
                'user_id' => Auth::id(), // Gunakan Auth::id() karena notifikasi ditujukan ke User
                'type' => 'success',
                'message' => 'Biodata dan Data Orang Tua berhasil direset. Silahkan lengkapi kembali data Anda.',
                'is_read' => 0,
            ]);
            
            return redirect()->route('profile.settings')->with('success', 'Biodata berhasil direset.');

        } catch (\Exception $e) {
            Log::error('Reset Biodata Gagal: ' . $e->getMessage());

            NotificationHistory::create([
                'user_id' => Auth::id(), // Gunakan Auth::id() karena notifikasi ditujukan ke User
                'type' => 'error',
                'message' => 'Biodata dan Data Orang Tua gagal direset.',
                'is_read' => 0,
            ]);
            return redirect()->back()->with('error', 'Gagal mereset biodata. Silakan coba lagi.');
        }
    }

    public function resetNilai()
    {
        /** @var \App\Models\Siswa $siswa */
        $user = Auth::user();
        $siswa = $user->siswa;
        $check = $this->checkRegistrationAndRedirect($siswa);
        if ($check) return $check;
        
        try {
            DB::transaction(function () use ($siswa, $user) {
                $user->raporFiles->each(function ($raporFile) {
                    if ($raporFile->file_path && Storage::disk('public')->exists($raporFile->file_path)) {
                        Storage::disk('public')->delete($raporFile->file_path);
                    }
                });

                $siswa->semesters()->delete(); 
                $user->raporFiles()->delete();
                
                // 2. Reset kolom nilai rata-rata di tabel Siswa (jika ada)
                $siswa->nilai_akhir = null;
                $siswa->save();

            });

            NotificationHistory::create([
                'user_id' => Auth::id(), 
                'type' => 'success',
                'message' => 'Data Nilai Rapor berhasil direset. Silahkan masukkan nilai kembali.',
                'is_read' => 0,
            ]);

            return redirect()->route('profile.settings')->with('success', 'Data Nilai berhasil direset.');

        } catch (\Exception $e) {
            Log::error('Reset Nilai Gagal: ' . $e->getMessage());

            NotificationHistory::create([
                'user_id' => Auth::id(), // Gunakan Auth::id() karena notifikasi ditujukan ke User
                'type' => 'error',
                'message' => 'Gagal mereset data nilai.',
                'is_read' => 0,
            ]);
            return redirect()->back()->with('error', 'Gagal mereset data nilai. Silakan coba lagi.');
        }
    }

    public function resetDokumen()
    {
        /** @var \App\Models\Siswa $siswa */
        $siswa = Auth::user()->siswa;
        $check = $this->checkRegistrationAndRedirect($siswa);
        if ($check) return $check;

        try {
            DB::transaction(function () use ($siswa) {
                
                // DAFTAR KOLOM DOKUMEN YANG HANYA AKAN DIRESET (SKL, Ijazah, Surat Pernyataan)
                $documentFields = [
                    'surat_keterangan_lulus',
                    'ijazah_file',
                    'surat_pernyataan',
                ];

                // 1. Hapus berkas dari storage (jika ada)
                foreach ($documentFields as $field) {
                    $filePath = $siswa->{$field};
                    // Memastikan kolom memiliki path dan file ada di storage sebelum dihapus
                    if ($filePath && Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }

                // 2. Reset kolom dokumen dan status di tabel Siswa
                foreach ($documentFields as $field) {
                    // Set kolom file menjadi NULL
                    $siswa->{$field} = null; 
                }
                
                // Reset status terkait, seperti status pendaftaran akun dari step 4
                // Asumsi: status_pendaftaran_akun adalah kolom yang menandai selesainya langkah ini
                $siswa->status_pendaftaran_akun = 'pending'; 
                $siswa->save();

                // CATATAN: Dokumen lain seperti foto, akta, sertifikat, dan afirmasi TIDAK direset
                // pada fungsi ini.

            });

            // NOTIFIKASI SUKSES
            NotificationHistory::create([
                'user_id' => Auth::id(), 
                'type' => 'success',
                'message' => 'Dokumen Surat Keterangan Lulus, Ijazah, dan Surat Pernyataan berhasil direset. Silahkan unggah ulang berkas Anda.',
                'is_read' => 0,
            ]);

            return redirect()->route('profile.settings')->with('success', 'Data Dokumen berhasil direset.');

        } catch (\Exception $e) {
            // Log error untuk diagnosis
            Log::error('Reset Dokumen Gagal: ' . $e->getMessage());

            // NOTIFIKASI ERROR
            NotificationHistory::create([
                'user_id' => Auth::id(), 
                'type' => 'error',
                'message' => 'Gagal menghapus dokumen. Terjadi kesalahan sistem.',
                'is_read' => 0,
            ]);
            
            return redirect()->back()->with('error', 'Gagal mereset dokumen. Silakan coba lagi.');
        }
    }
}