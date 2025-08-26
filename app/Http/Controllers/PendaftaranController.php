<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Ortu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function showTimeline(Request $request)
    {
        $progress = Auth::user()->timelineProgress->current_step ?? 1;

        $currentStep = $request->input('step', $progress);
        if ($currentStep > $progress) {
            $currentStep = $progress;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user()->load('siswa.ortu');

        return view('dashboard', [
            'currentStep' => (int)$currentStep,
            'siswa' => $user->siswa,
            'isPasswordChanged' => true,
        ]);
    }

    public function saveRegistration(Request $request)
    {
        // dd($request->all());

        $step = $request->input('current_step');

        switch ($step) {
            case 1:
                $this->_saveBiodata($request);
                break;
            case 2:
                // $this->_saveRapor($request);
                // break;
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
                        ->with('success', 'Data Langkah ' . $step . ' Data berhasil disimpan.');
    }

    private function _saveBiodata(Request $request)
    {
        $validatedData = $request->validate([
            // file
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'akta' => 'required|file|mimes:pdf|max:2048',

            // data siswa
            'jenis_kelamin' => 'nullable|string',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_kk' => 'nullable|string',
            'nik' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'email' => 'nullable|string',
            'agama' => 'nullable|string',
            'kebutuhan_k' => 'nullable|string',
            'sekolah_asals_id' => 'nullable|string', // nanti diubah
            
            // data wali
            'nama_wali' => 'nullable|string|max:255',
            'tempat_lahir_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'alamat_wali' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData, $request) {
            $user = Auth::user();
            $siswa = $user->siswa;

            if (!$siswa) {
                $siswa = new Siswa();
                $siswa->user_id = $user->id;
            }

            $pathFoto = $request->file('foto')->store('profile_murid', 'public');
            $pathAkta = $request->file('akta')->store('akta_murid', 'public');

            $siswa->fill($validatedData);
            $siswa->foto = $pathFoto;
            $siswa->akta = $pathAkta;
            $siswa->save();

            $ortu = $siswa->ortu;
            if (!$ortu) {
                $ortu = new Ortu();
                $ortu->siswa()->associate($siswa);
            }
            $ortu->fill($validatedData);
            $ortu->save();
        });

        return redirect()->route('timeline', ['step' => 2])->with('success', 'Biodata berhasil disimpan.');
    }
}
