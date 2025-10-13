@extends('admin_sekolah.layouts.admin_layout')

@section('content')
@php
    $selection_ended = $selection_ended ?? true; // Fallback agar tidak error
@endphp
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            @if ($selection_ended)
                <div class="top-0 left-0 right-0 z-50 p-3 bg-green-600 shadow-xl">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <p class="text-white text-center font-bold text-lg">
                            🎉 PROSES SELEKSI SELESAI! INI ADALAH HASIL AKHIR PERINGKAT SISWA. 🎉
                        </p>
                    </div>
                </div>
                <div class="pt-5"></div> 
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (!$selection_ended)                    
                <h3 class="text-lg font-semibold mb-4">
                    Peringkat Sementara Siswa Jalur {{ $jalurs->firstWhere('id', $jalur_id)->nama_jalur_pendaftaran ?? 'Pendaftaran' }} {{ Auth::user()->sma->nama_sma ?? '' }}
                </h3>
                @endif

                <div class="flex space-x-4 mb-6">
                    @foreach ($jalurs as $jalur)
                        <a href="{{ route('admin.peringkat_murid.show', $jalur->id) }}" class="px-4 py-2 rounded-md {{ request()->route('jalur_id') == $jalur->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                            {{ $jalur->nama_jalur_pendaftaran }}
                        </a>
                    @endforeach
                </div>
                
                <h3 class="text-lg font-semibold mb-4 mt-6">Daftar Peringkat Siswa</h3>
                
                @if ($siswas->isEmpty())
                    <div class="text-center text-gray-500">
                        Belum ada siswa yang terverifikasi pada jalur ini.
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
                            {{-- Header Tabel --}}
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah Asal</th>
                                    
                                    @if ($jalur_id == 2 || $jalur_id == 3)
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak (km)</th>
                                    @else
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                        <div class="max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php 
                                        $ranking = 0; 
                                    @endphp
                                    @foreach ($siswas as $siswa)
                                    @php
                                        $ranking++;
                                        $isDiLuarKuota = ($ranking > $kuotaJalur);
                                        $rowClass = $isDiLuarKuota ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-white hover:bg-green-50';
                                    @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-center text-blue-600">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <div class="flex items-center space-x-1">
                                                    <span>{{ $siswa->user->name }}</span>
                                                    @if ($jalur_id == 1 && $siswa->verifikasi_sertifikat === 'terverifikasi')
                                                        <div class="bg-green-500 rounded-md" title="Sertifikat Terverifikasi">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="white" class="size-4">
                                                                <path d="M6 6v4h4V6H6Z" />
                                                                <path fill-rule="evenodd" d="M5.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3a2 2 0 0 0 2 2v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13a2 2 0 0 0 2-2h1.25a.75.75 0 0 0 0-1.5H13v-.75h1.25a.75.75 0 0 0 0-1.5H13V6.5h1.25a.75.75 0 0 0 0-1.5H13a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-.75V1.75a.75.75 0 0 0-1.5 0V3H6.5V1.75A.75.75 0 0 0 5.75 1ZM11 4.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V5a.5.5 0 0 1 .5-.5h6Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->nisn }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                                {{-- {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }} --}}
                                                {{ $siswa->tanggal_lahir }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->sekolahAsal->nama_sekolah }}
                                            </td>
                                            
                                            @if ($jalur_id == 2 || $jalur_id == 3)
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-red-600 font-bold">
                                                    {{ $siswa->jarak_ke_sekolah ?? $siswa->jarak_ke_sma_km }} KM
                                                </td>
                                            @else
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-green-600 font-bold">
                                                    {{ $siswa->nilai_akhir }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @php
                        $totalSiswaTerverifikasi = $siswas->filter(function ($siswa) {
                            return $siswa->verifikasi_sertifikat === 'terverifikasi';
                        })->count();
                    @endphp
                    <div class="mt-8 text-sm text-gray-500">
                        <p> Ketetarangan : <br>
                            - Peringkat dihitung berdasarkan kriteria seleksi jalur {{ $jalurs->firstWhere('id', $jalur_id)->nama_jalur_pendaftaran ?? '' }} (Nilai Akhir untuk Prestasi, Jarak untuk Zonasi, dan Dokumen untuk Afirmasi). <br>
                            - Murid dengan tanda <span class="text-red-500 font-extrabold">Merah</span> merupakan murid yang berada di luar batas kuota
                        </p>      
                        <div class="flex items-center gap-x-1">
                        @if ($jalur_id == 1 && $totalSiswaTerverifikasi > 0)
                        -<div class="bg-green-500 rounded-md w-fit" title="Siswa Terverifikasi Sertifikat">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="white" class="size-4">
                                        <path d="M6 6v4h4V6H6Z" />
                                        <path fill-rule="evenodd" d="M5.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3a2 2 0 0 0 2 2v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13a2 2 0 0 0 2-2h1.25a.75.75 0 0 0 0-1.5H13v-.75h1.25a.75.75 0 0 0 0-1.5H13V6.5h1.25a.75.75 0 0 0 0-1.5H13a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-.75V1.75a.75.75 0 0 0-1.5 0V3H6.5V1.75A.75.75 0 0 0 5.75 1ZM11 4.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V5a.5.5 0 0 1 .5-.5h6Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="font-bold">
                                    <span class="text-green-600">Siswa Dengan Sertifikat Terverifikasi :</span> {{ $totalSiswaTerverifikasi }} siswa
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection