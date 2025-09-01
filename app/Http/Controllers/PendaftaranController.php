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

        return view('dashboard', [
            'currentStep' => (int)$currentStep,
            'siswa' => $siswa,
            'ortu' => $ortu,
            'sekolahAsals' => $sekolahAsals,
            'isPasswordChanged' => true,

            'mapels' => $mapels,
            'semesters' => $user->semesters,
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
                // $this->_saveSuratPernyataan($request);
                // break;
            case 4:
                // $this->_saveSuratKeteranganLulus($request);
                // break;
        }

        $progress = Auth::user()->timelineProgress;
        $nextStep = (int)$step + 1;

        if ($nextStep > $progress->current_step) {
            $progress->current_step = $nextStep;
            $progress->save();
        }

        return redirect()->route('dashboard', ['step' => $nextStep])
                        ->with('success', 'Data Langkah ' . $step . ' berhasil disimpan.');
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
            'sekolah_asal_id' => 'required|exists:sekolah_asals,id', // nanti diubah
            
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
                $siswa->foto = $request->file('foto')->store('profile_murid', 'public');
            }
            if ($request->hasFile('akta')) {
                $siswa->akta = $request->file('akta')->store('akta_murid', 'public');
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

        return redirect()->route('dashboard', ['step' => 2])->with('success', 'Biodata berhasil disimpan.');
    }

    private function _saveRapor(Request $request)
    {
        try {
            // Validasi data rapor
            $validated = $request->validate([
                'nilai' => 'required|array',
                'rapor_file' => 'nullable|array',
                'rapor_file.*' => 'nullable|mimes:pdf|max:1000'
            ]);

            DB::beginTransaction();

            $userId = Auth::id();
            $dataNilai = $validated['nilai'];

            Semester::where('user_id', $userId)->delete();
            RaporFile::where('user_id', $userId)->delete();

            $mapels = Mapel::all();

            foreach ($dataNilai as $semester => $nilaiMapel) {
                if ($request->hasFile("rapor_file.{$semester}")) {
                    $file = $request->file("rapor_file.{$semester}");
                    $fileName = $file->hashName('rapor_murid/' . $userId);
                    Storage::disk('public')->put($fileName, file_get_contents($file));

                    RaporFile::create([
                        'user_id' => $userId,
                        'semester' => $semester,
                        'file_rapor' => $fileName
                    ]);
                }

                foreach ($nilaiMapel as $namaMapel => $nilai) {
                    $namaMapelDariForm = Str::replace('_', ' ', $namaMapel);

                    $mapelId = $mapels->firstWhere(function ($mapel) use ($namaMapelDariForm) {
                        return Str::lower($mapel->nama_mapel) === Str::lower($namaMapelDariForm);
                    })->id ?? null;

                    if ($nilai !== null && $mapelId !== null) {
                        Semester::create([
                            'user_id' => $userId,
                            'mapel_id' => $mapelId,
                            'semester' => $semester,
                            'nilai_semester' => $nilai
                        ]);
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
}