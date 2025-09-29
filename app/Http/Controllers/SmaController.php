<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\DataSma;
use App\Models\Semester;
use App\Models\RaporFile;
use App\Models\SekolahAsal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Models\JalurPendaftaran;
use App\Models\TimelineProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SmaController extends Controller
{
    /**
     * Tampilkan halaman daftar SMA.
     */
    public function index()
    {
        $data_sekolah_sma = DataSma::with('akreditasi')->withCount('siswas')->get();
        return view('pendaftaran_sma', compact('data_sekolah_sma'));
    }

    public function testField()
    {
        return view('test_field');
    }

    public function showJalurPendaftaran(Request $request)
    {
        $validated = $request->validate([
            'sma_id' => 'required|integer|exists:sma_datas,id',
        ]);
        
        $sma_id = $validated['sma_id'];
        $jalur_pendaftaran = JalurPendaftaran::all();
        return view('registration.sma_form.jalur_pendaftaran_sma', compact('jalur_pendaftaran', 'sma_id'));
    }

    public function showResume()
    {
        $siswa = Auth::user()->siswa->load(['jalurPendaftaran', 'dataSma', 'semesters.mapels']);
        return view('registration.sma_form.resume_sma', compact('siswa'));
    }

    public function saveJalurPendaftaran(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validated = $request->validate([
            'jalur_pendaftaran_id' => [
                'required',
                'integer',
                Rule::exists('jalur_pendaftarans', 'id'),
            ],
            'sma_id' => [
                'required',
                'integer',
                Rule::exists('sma_datas', 'id'),
            ],
        ]);

        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->back()->with('error', 'Pengguna tidak terautentikasi.');
            }

            $siswa = Siswa::firstOrNew(['user_id' => $user->id]);
            $siswa->jalur_pendaftaran_id = $validated['jalur_pendaftaran_id'];
            $siswa->data_sma_id = $validated['sma_id'];
            // dd($siswa);
            $siswa->save();

            $timelineProgress = TimelineProgress::firstOrNew(['user_id' => $user->id]);
            $timelineProgress->current_step = 1;
            $timelineProgress->sma_id = $validated['sma_id'];
            // dd($timelineProgress);
            $timelineProgress->save();


            return redirect()->route('pendaftaran.sma.timeline', ['step' => 1])
                ->with('success', 'Jalur dan SMA berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan jalur dan SMA: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }


    public function showTimeline(Request $request, $pathStep = null)
    {        
        $progress = Auth::user()->timelineProgress->current_step ?? 1;
        $currentStep = $pathStep ?? $request->query('step', $progress);
        $currentStep = (int) $currentStep;
        if ($currentStep > $progress) {
            $currentStep = $progress;
        }
        
        $siswa = Auth::user()->siswa;

        // Logika Menghitung Nilai Akhir
        $allNilai = $siswa->semesters->pluck('nilai_semester');
        $totalNilai = $allNilai->sum();
        $jumlahEntri = $allNilai->count();
        $nilaiAkhir = $jumlahEntri > 0 ? $totalNilai / $jumlahEntri : 0;

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
        $jalurId = $siswa->jalur_pendaftaran_id ?? null;
        $smaLatitude = $selectedSma->latitude ?? -6.200000;
        $smaLongitude = $selectedSma->longitude ?? 106.916666;

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

            'nilaiAkhir' => $nilaiAkhir,
            'jalurId' => $jalurId,

            'smaLatitude' => $smaLatitude,
            'smaLongitude'=> $smaLongitude,
        ]);

    }
    
    public function savePendaftaran(Request $request): RedirectResponse
    {
        $currentStep = (int) $request->input('current_step');
        $siswa = Auth::user()->siswa;
        $jalurId = $siswa->jalur_pendaftaran_id;    

        try {
            DB::beginTransaction();

            switch ($currentStep) {
                case 1:
                    $this->_saveBiodata($request);
                    break;
                case 2:
                    $this->_saveRapor($request);
                    break;
                case 3:
                    if ($jalurId == 2) {
                        $this->_saveAfirmasi($request);
                    } else {
                        $this->_saveSertifikat($request);
                    }
                    break;
                case 4: 
                    $this->_savePrestasi($request);
                    break;
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
        // dd($request->all());
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
        
        DB::transaction(function () use ($validatedData, $request) {
            $user = Auth::user();
            $user->email = $validatedData['email'];

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

            $ortuData = $request->only([
                'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali', 'pekerjaan_wali', 'alamat_wali'
            ]);

            Ortu::updateOrCreate(
                ['siswa_id' => $siswa->id],
                $ortuData
            );   
        });
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

    private function _saveSertifikat(Request $request)
    {
    $validatedData = $request->validate([
        'sertifikat_file' => 'nullable|file|mimes:pdf|max:500',
    ]);

    $siswa = Auth::user()->siswa;

    if (!$siswa) {
        throw new \Exception('Data siswa tidak ditemukan.');
    }

    if ($request->hasFile('sertifikat_file')) {
        if ($siswa->sertifikat_file && Storage::disk('public')->exists($siswa->sertifikat_file)) {
            Storage::disk('public')->delete($siswa->sertifikat_file);
        }
        
        $filePath = $request->file('sertifikat_file')->store('sertifikat_murid', 'public');
        $siswa->sertifikat_file = $filePath;
        $siswa->save();
    }
    }

    private function _saveAfirmasi(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'document_afirmasi' => 'required|file|mimes:pdf|max:1024',
            'lat_siswa' => 'required|numeric',
            'lng_siswa' => 'required|numeric',
        ]);

        $siswa = Auth::user()->siswa;
        $selectedSma = DataSma::find($siswa->data_sma_id);

        if (!$siswa) {
            throw new \Exception('Data siswa atau SMA tidak ditemukan.');
        }

        if ($request->hasFile('document_afirmasi')) {
            if ($siswa->document_afirmasi && Storage::disk('public')->exists($siswa->document_afirmasi)) {
                Storage::disk('public')->delete($siswa->document_afirmasi);
            }

            $filePath = $request->file('document_afirmasi')->store('document_afirmasi_murid', 'public');
            $siswa->document_afirmasi = $filePath;
        }

        $siswa->latitude_siswa = $request->input('lat_siswa');
        $siswa->longitude_siswa = $request->input('lng_siswa');
        
        $distance = $this->calculateDistance(
            $selectedSma->latitude, $selectedSma->longitude,
            $siswa->latitude_siswa, $siswa->longitude_siswa
        );
        $siswa->jarak_ke_sma_km = round($distance, 2);

        $siswa->save();
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

    private function _savePrestasi(Request $request)
    {
        $siswa = Auth::user()->siswa;
        $siswa->status_pendaftaran = 'completed';
        if ($request->has('nilai_akhir')) {
            $siswa->nilai_akhir = $request->input('nilai_akhir');
        }
        
        $siswa->save();
        Auth::user()->timelineProgress->delete();
        DB::commit();
        return redirect()->route('pendaftaran_sma')->with('success', 'Pendaftaran Anda berhasil diselesaikan!');
    }
    
}
