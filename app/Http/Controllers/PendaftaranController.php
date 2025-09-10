<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\RaporFile;
use App\Models\SekolahAsal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PendaftaranController extends Controller
{
    public function showTimeline(Request $request, $pathStep = null)
    {
        $progress = Auth::user()->timelineProgress->current_step ?? 1;
        $currentStep = $pathStep ?? $request->query('step', $progress);
        $currentStep = (int) $currentStep;
        if ($currentStep > $progress) {
            $currentStep = $progress;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user()->load('siswa.ortu', 'semesters', 'raporFiles');
        $siswa = $user->siswa;
        $ortu  = $siswa->ortu ?? null;
        $sekolahAsals = SekolahAsal::all();
        $mapels = Mapel::all();
        $isPasswordChanged = Auth::user()->password_changed_at;
        
        $tanggal_lahir_formatted = null;
        if ($siswa && $siswa->tanggal_lahir) {
            $tanggal_lahir_formatted = Carbon::parse($siswa->tanggal_lahir)->format('dmY');
        }

        $raporData = [];
        for ($semester = 1; $semester <= 5; $semester++) {
            $raporData[$semester] = [
                'file_rapor' => $user->raporFiles->firstWhere('semester', $semester),
            ];
        }

        return view('dashboard', [
            'currentStep' => (int)$currentStep,
            'siswa' => $siswa,
            'ortu' => $ortu,
            'sekolahAsals' => $sekolahAsals,
            'isPasswordChanged' => $isPasswordChanged,
            'tanggal_lahir_formatted' => $tanggal_lahir_formatted,

            'mapels' => $mapels,
            'semesters' => $user->semesters,
            'raporData' => $raporData,
            'raporFiles' => $user->raporFiles,
        ]);

    }

    public function saveRegistration(Request $request)
    {
        $step = $request->input('current_step');

        switch ($step) {
            case 1:
                $this->_saveBiodata($request);
                break;
            case 2:
                $this->_saveRapor($request);
                break;
            case 3:
                $this->_saveSuratPernyataan($request);
                break;
            case 4:
                $this->_saveSuratKeteranganLulus($request);
                break;
        }

        $progress = Auth::user()->timelineProgress;
        $nextStep = (int)$step + 1;

        if ($nextStep > $progress->current_step) {
            $progress->current_step = $nextStep;
            $progress->save();
        }

        return redirect()->route('dashboard', ['step' => $nextStep]);
    }

    private function _saveBiodata(Request $request)
    {
        $validatedData = $request->validate([
            // file
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'akta_file' => 'nullable|file|mimes:pdf|max:2048',

            // data siswa
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
            
            // data wali
            'nama_wali' => 'nullable|string|max:255',
            'tempat_lahir_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'alamat_wali' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData, $request) {
            $user = Auth::user();

            $user->email = $validatedData['email'];
            $user->save();

            $siswa = $user->siswa;

            $siswa = $user->siswa ?? new Siswa();
            $siswa->user_id = $user->id;

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
            

            $siswaData = collect($validatedData)->except([
                'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'pekerjaan_wali', 'alamat_wali', 'foto', 'akta', 'email'
            ])->toArray();

            // dd($validatedData);

            $siswa->fill($siswaData);
            $siswa->save();

            $ortu = $siswa->ortu ?? new Ortu();
            $ortu->siswa()->associate($siswa);

            $ortuData = $request->only([
                'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'pekerjaan_wali', 'alamat_wali'
            ]);

            $ortu->fill($ortuData);
            $ortu->save();
        });

        return redirect()->route('dashboard')->with('success', 'Biodata berhasil disimpan!');
    }

    private function _saveRapor(Request $request)
    {
        try {
            // Validasi data rapor
            $validated = $request->validate([
                'nilai' => 'required|array|max:100',
                'rapor_file' => 'nullable|array',
                'rapor_file.*' => 'nullable|mimes:pdf|max:1000'
            ]);

            DB::beginTransaction();

            $userId = Auth::id();
            $dataNilai = $validated['nilai'];
            $mapels = Mapel::all();
            $rapor_file = RaporFile::all();

            foreach ($dataNilai as $semester => $nilaiMapel) {
                if ($request->hasFile("rapor_file.{$semester}")) {
                    $file = $request->file("rapor_file.{$semester}");

                    $existingRaporFile = RaporFile::where('user_id', $userId)->where('semester', $semester)->first();

                    if ($existingRaporFile && Storage::disk('public')->exists($existingRaporFile->file_rapor)) {
                        Storage::disk('public')->delete($existingRaporFile->file_rapor);
                    }
                    
                    $fileName = $file->hashName('rapor_murid/' . $userId);
                    $file->storeAs('rapor_murid/' . $userId, $fileName, 'public');

                    RaporFile::updateOrCreate(
                        ['user_id' => $userId,
                        'semester' => $semester],
                        ['file_rapor' => $fileName]
                    );
                }

                foreach ($nilaiMapel as $namaMapel => $nilai) {
                    $namaMapelDariForm = Str::replace('_', ' ', $namaMapel);

                    $mapelId = $mapels->firstWhere(function ($mapel) use ($namaMapelDariForm) {
                        return Str::lower($mapel->nama_mapel) === Str::lower($namaMapelDariForm);
                    })->id ?? null;

                    if ($nilai !== null && $mapelId !== null) {
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
            return redirect()->back()->with('success', 'Data rapor berhasil disimpan!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan rapor: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function _saveSuratPernyataan(Request $request)
    {
        $validated = $request->validate([
            'surat_pernyataan' => 'nullable|file|mimes:pdf|max:2048',
            ]);

        DB::transaction(function () use ($validated, $request) {
            $user = Auth::user();
            $siswa = $user->siswa;

            if ($request->hasFile('surat_pernyataan')) {
                if ($siswa->surat_pernyataan && Storage::disk('public')->exists($siswa->surat_pernyataan)) {
                    Storage::disk('public')->delete($siswa->surat_pernyataan);
                }
                $siswa->surat_pernyataan = $request->file('surat_pernyataan')->store('surat_pernyataan', 'public');
                $siswa->save();
            }
        });

        return redirect()->route('dashboard')->with('success', 'Surat Pernyataan berhasil diupload!');

    }
    
    public function _saveSuratKeteranganLulus(Request $request)
    {
        $validated = $request->validate([
            'surat_keterangan_lulus' => 'nullable|file|mimes:pdf|max:2048',
            'ijazah_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);

        DB::transaction(function () use ($validated, $request) {
            $user = Auth::user();
            $siswa = $user->siswa;

            if ($request->hasFile('surat_keterangan_lulus')) {
                if ($siswa->surat_keterangan_lulus && Storage::disk('public')->exists($siswa->surat_keterangan_lulus)) {
                    Storage::disk('public')->delete($siswa->surat_keterangan_lulus);
                }
                $siswa->surat_keterangan_lulus = $request->file('surat_keterangan_lulus')->store('surat_keterangan_lulus', 'public');
                $siswa->save();
            }
            if ($request->hasFile('ijazah_file')) {
                if ($siswa->ijazah_file && Storage::disk('public')->exists($siswa->ijazah_file)) {
                    Storage::disk('public')->delete($siswa->ijazah_file);
                }
                $siswa->ijazah_file = $request->file('ijazah_file')->store('ijazah_file', 'public');
                $siswa->save();
            }
        });

        return redirect()->route('dashboard')->with('success', 'Surat Keterangan Lulus dan Ijazah berhasil disubmit!');
    }
}