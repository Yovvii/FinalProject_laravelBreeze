<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function showSuratPernyataan()
    {
        Carbon::setLocale('id');

        /** @var \App\Models\User $user */
        $user = Auth::user()->load('siswa.ortu');
        $siswa = $user->siswa;
        $ortu = $siswa->ortu ?? null;

        $nama_siswa = $user->name ?? '';
        $nisn = $siswa->nisn ?? '';
        $kabupaten = $siswa->kabupaten;
        $tanggal_lahir = isset($siswa->tanggal_lahir) ? Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM YYYY') : '';
        $alamat_siswa = $siswa->alamat;
        $nama_sekolah = 'SMA LaravGone';
        $tanggal_surat = Carbon::now()->isoFormat('dddd, DD MMMM YYYY');
        $nama_wali = $ortu->nama_wali ?? '';

        return view('document.surat_pernyataan_file', compact('nama_siswa', 'nisn','kabupaten', 'tanggal_lahir', 'alamat_siswa', 'nama_sekolah', 'tanggal_surat', 'nama_wali'));
    }

    /**
     * Membuat dan mengunduh file Surat Pernyataan dalam format DOCX.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Request $request)
    {
        Carbon::setLocale('id');

        /** @var \App\Models\User $user */
        $user = Auth::user()->load('siswa.ortu');
        $siswa = $user->siswa;
        $ortu = $siswa->ortu ?? null;

        $nama_siswa = $user->name ?? '';
        $nisn = $siswa->nisn ?? '';
        $kabupaten = $siswa->kabupaten;
        $tanggal_lahir = isset($siswa->tanggal_lahir) ? Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM YYYY') : '';
        $alamat_siswa = $siswa->alamat;
        $nama_sekolah = 'SMA LaravGone';
        $tanggal_surat = Carbon::now()->isoFormat('dddd, DD MMMM YYYY');
        $nama_wali = $ortu->nama_wali ?? '';

        // Tentukan view yang akan digunakan untuk PDF dan kirim datanya
        $pdf = PDF::loadView('document.surat_pernyataan_file', compact('nama_siswa', 'nisn', 'kabupaten', 'tanggal_lahir', 'alamat_siswa', 'nama_sekolah', 'tanggal_surat', 'nama_wali'));

        // Unduh PDF
        return $pdf->download('Surat_Pernyataan_Kesanggupan.pdf');
    }
}
