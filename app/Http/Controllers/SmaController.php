<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\RaporFile;
use Illuminate\Support\Str;
use App\Models\TimelineProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use App\Models\Mapel;
use App\Models\DataSma;
use App\Models\JalurPendaftaran;
use App\Models\SekolahAsal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmaController extends Controller
{
    /**
     * Tampilkan halaman daftar SMA.
     */
    public function index()
    {
        $data_sekolah_sma = DataSma::with('akreditasi')->get();
        return view('pendaftaran_sma', compact('data_sekolah_sma'));
    }

    public function showJalurPendaftaran()
    {
        $jalur_pendaftaran = JalurPendaftaran::all();
        return view('registration.sma_form.jalur_pendaftaran_sma', compact('jalur_pendaftaran'));
    }

    public function saveJalurPendaftaran(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jalur_pendaftaran_id' => [
    'required',
    'integer',
    'exists:App\Models\JalurPendaftaran,id',
],
        ]);

        try {
            $siswa = Auth::user()->siswa;
            if ($siswa) {
                $siswa->jalur_pendaftaran_id = $validated['jalur_pendaftaran_id'];
                $siswa->save();
            }
            return redirect()->route('pendaftaran.sma.timeline', ['step' => 1])->with('success', 'Jalur pendaftaran berhasil disimpan.');
        } catch (\Exception $e) {
            log::error('Gagal menyimpan jalur pendaftaran : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan jalur');
        }
    }

    public function showTimeline(Request $request, $pathStep = null)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if ($request->has('sma_id') && $siswa) {
            $smaId = (int) $request->input('sma_id');
            if ($siswa->data_sma_id === null || $siswa->data_sam_id !== $smaId) {
                $siswa->data_sma_id = $smaId;
                $siswa->save();
            }
        }

        if (!$user->timelineProgress) {
            TimelineProgress::create([
                'user_id' => $user->id,
                'current_step' => 1,
            ]);
        }

        $progress = Auth::user()->timelineProgress->current_step ?? 1;
        $currentStep = $pathStep ?? $request->query('step', $progress);
        $currentStep = (int) $currentStep;
        if ($currentStep > $progress) {
            $currentStep = $progress;
        }

        $siswa->refresh();
        /** @var \App\Models\User $user */
        $user = Auth::user()->load('siswa.ortu', 'semesters', 'raporFiles');
        $siswa = $user->siswa;
        $ortu  = $siswa->ortu ?? null;
        $sekolahAsals = SekolahAsal::all();
        $mapels = Mapel::all();
        $isPasswordChanged = Auth::user()->password_changed_at;
        $data_sma = DataSma::all();
        
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

        $selectedSma = DataSma::find($siswa->data_sma_id) ?? null;

        return view('registration.sma_form.timeline_sma', [
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
            'selectedSma' => $selectedSma,
        ]);

    }
    
    public function saveRegistration(Request $request): RedirectResponse
    {
        $currentStep = (int) $request->input('current_step');

        try {
            DB::beginTransaction();

            switch ($currentStep) {
                case 1: // Langkah Biodata
                    $this->_saveBiodata($request);
                    break;
                case 2: // Langkah Rapor
                    $this->_saveRapor($request);
                    break;
                case 3: // Langkah Surat Pernyataan
                    // $this->_saveSuratPernyataan($request);
                    // break;
                case 4: // Langkah Surat Keterangan Lulus
                    // $this->_saveSuratKeteranganLulus($request);
                    // break;
                default:
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Langkah tidak valid.');
            }

            // Setelah data disimpan, tingkatkan langkah dan simpan progres
            $timelineProgress = Auth::user()->timelineProgress;
            $nextStep = (int)$currentStep + 1;
            
            if ($nextStep > $timelineProgress->current_step) {
                $timelineProgress->current_step = $nextStep;
                $timelineProgress->save();
            }

            DB::commit();

            return redirect()->route('pendaftaran.sma.timeline', ['step' => $nextStep])
                ->with('success', 'Data berhasil disimpan. Silakan lanjutkan ke langkah berikutnya.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput()
                ->with('error', 'Gagal menyimpan data. Pastikan semua data sudah diisi dengan benar.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan data timeline: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    private function _saveBiodata(Request $request)
    {
        $validatedData = $request->validate([
            // file
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'akta_file' => 'nullable|file|mimes:pdf|max:2048',

            // data siswa
            'jenis_kelamin' => 'required|string',
            'kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string',
            'alamat' => 'required|string',
            'no_kk' => 'required|string',
            'nik' => 'required|string',
            'no_hp' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'email' => 'required|string',
            'agama' => 'required|string',
            'kebutuhan_k' => 'nullable|string',
            'sekolah_asal_id' => 'required|integer',
            
            // data wali
            'nama_wali' => 'nullable|string|max:255',
            'tempat_lahir_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'alamat_wali' => 'nullable|string|max:255',
        ]);
        
        $user = Auth::user();
        $user->email = $validatedData['email'];
        $user->save();

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
            'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'pekerjaan_wali', 'alamat_wali', 'foto', 'akta_file', 'email'
        ])->toArray();

        $siswa->fill($siswaData);
        $siswa->save();

        $ortu = $siswa->ortu ?? new Ortu();
        $ortu->siswa()->associate($siswa);

        $ortuData = $request->only([
            'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'pekerjaan_wali', 'alamat_wali'
        ]);

        $ortu->fill($ortuData);
        $ortu->save();
    }    

    private function _saveRapor(Request $request)
    {
        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*.*' => 'nullable|numeric|min:0|max:100',
            'rapor_file' => 'nullable|array',
            'rapor_file.*' => 'nullable|mimes:pdf|max:1000'
        ]);

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
    }
}
