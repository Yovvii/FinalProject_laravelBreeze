@extends('admin_sekolah.layouts.admin_layout')

@section('content')
@php
    // Pastikan variabel tersedia dengan fallback
    $selection_ended = $selection_ended ?? false; 
    $current_jalur_name = $jalurs->firstWhere('id', $jalur_id)->nama_jalur_pendaftaran ?? 'Pendaftaran';
@endphp
    <div class="py-5">
        <div class="max-w-[1235px] mx-auto sm:px-4 lg:px-6">
            @if ($selection_ended)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10 text-center border-t-4 border-green-600">
                    <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-2xl font-bold text-gray-800 mt-4">Verifikasi Berkas Pendaftaran Ditutup</h3>
                    <p class="text-gray-600 mt-2">
                        Pendaftaran dan verifikasi siswa pada jalur ini telah <span class="font-bold text-black">Resmi Berakhir</span>.
                        Anda tidak dapat lagi melakukan tindakan Terima atau Tolak pada siswa manapun.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.show_peringkat_murid') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Lihat Hasil Peringkat Akhir
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Daftar Siswa Per Jalur Pendaftaran {{ Auth::user()->sma->nama_sma ?? '' }}</h3>
                    
                    <div class="flex space-x-4 mb-6">
                        @foreach ($jalurs as $jalur)
                            <a href="{{ route('admin.jalur_pendaftaran.show', $jalur->id) }}" class="px-4 py-2 rounded-md {{ request()->route('jalur_id') == $jalur->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $jalur->nama_jalur_pendaftaran }}
                            </a>
                        @endforeach
                    </div>
                    
                    {{-- <div class="flex mb-4 mt-6 justify-between content-center">
                        <h3 class="text-lg font-semibold">Daftar Siswa</h3>
                        @if ($jalur_id == 1)
                            <a href="{{ route('admin.sertifikat_murid') }}">
                                <p class="text-sm text-red-500 content-center hover:text-red-300">Pendaftar Dengan Sertifikat</p>
                            </a>
                        @endif
                    </div> --}}
                    
                    @if ($siswas->isEmpty())
                        <div class="text-center text-gray-500">
                            Belum ada siswa yang terdaftar pada jalur ini.
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah Asal</th>
                                        
                                        @if ($jalur_id == 1)
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Verifikasi</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen Sertifikat</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi Verifikasi</th>
                                        @elseif ($jalur_id == 2)
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Verifikasi</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak (KM)</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi Verifikasi</th>
                                        @else 
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak (KM)</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-50">
                                    @foreach ($siswas as $siswa)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="px-2 rounded-full w-fit">
                                                    {{ $siswa->user->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->nisn }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->sekolahAsal->nama_sekolah }}
                                            </td>
                                            
                                            @if ($jalur_id == 1)                                            
                                                @if ($siswa->sertifikat_file)
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                        @php
                                                            $status = $siswa->verifikasi_sertifikat ?? 'pending';
                                                            $color = match($status) {
                                                                'terverifikasi' => 'bg-green-100 text-green-800',
                                                                'ditolak' => 'bg-red-100 text-red-800',
                                                                default => 'bg-yellow-100 text-yellow-800',
                                                            };
                                                        @endphp
                                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $color }}">
                                                            {{ ucfirst($status) }}
                                                        </span>
                                                    </td>
                                                    
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                        <a href="{{ Storage::url($siswa->sertifikat_file) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                                            Lihat File
                                                        </a>
                                                    </td>
                                                    
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                        @php
                                                            $currentStatus = $siswa->verifikasi_sertifikat ?? 'pending';
                                                        @endphp
                                                        
                                                        <form action="{{ route('admin.verifikasi_sertifikat', $siswa) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            <input type="hidden" name="status" value="terverifikasi">
                                                            <button type="submit" 
                                                                class="font-bold py-1 px-3 rounded-md text-xs transition ease-in-out duration-150
                                                                    @if ($currentStatus == 'terverifikasi')
                                                                        bg-green-300 text-gray-700 cursor-not-allowed opacity-75
                                                                    @else
                                                                        bg-green-500 hover:bg-green-600 text-white
                                                                    @endif"
                                                                @if ($currentStatus == 'terverifikasi') disabled @endif>
                                                                Terima
                                                            </button>
                                                        </form>
                                                        
                                                        {{-- Tombol Tolak --}}
                                                        <form action="{{ route('admin.verifikasi_sertifikat', $siswa) }}" method="POST" class="inline-block ms-1">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="submit" 
                                                                class="font-bold py-1 px-3 rounded-md text-xs transition ease-in-out duration-150
                                                                    @if ($currentStatus == 'ditolak')
                                                                        bg-red-300 text-gray-700 cursor-not-allowed opacity-75
                                                                    @else
                                                                        bg-red-500 hover:bg-red-600 text-white
                                                                    @endif"
                                                                @if ($currentStatus == 'ditolak') disabled @endif>
                                                                Tolak
                                                            </button>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 italic">
                                                        Tidak memakai sertifikat
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 italic">
                                                        Tidak memakai sertifikat
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 italic">
                                                        Tidak memakai sertifikat
                                                    </td>
                                                @endif
                                                
                                            @elseif ($jalur_id == 2)

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                    @php
                                                        $status = $siswa->verifikasi_afirmasi ?? 'pending';
                                                        $color = match($status) {
                                                            'terverifikasi' => 'bg-green-100 text-green-800',
                                                            'ditolak' => 'bg-red-100 text-red-800',
                                                            default => 'bg-yellow-100 text-yellow-800',
                                                        };
                                                    @endphp
                                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $color }}">
                                                        {{ ucfirst($status) }}
                                                    </span>
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-red-600 font-bold">
                                                    {{ $siswa->jarak_ke_sekolah ?? $siswa->jarak_ke_sma_km }} KM
                                                </td>
                                                
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                    @if ($siswa->document_afirmasi)
                                                        <a href="{{ Storage::url($siswa->document_afirmasi) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                                            Lihat File
                                                        </a>
                                                    @else
                                                        <span class="text-gray-400">N/A</span>
                                                    @endif
                                                </td>
                                                
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                    @if ($siswa->document_afirmasi)
                                                        @php
                                                            $currentStatus = $siswa->verifikasi_afirmasi ?? 'pending';
                                                        @endphp
                                                        
                                                        <form action="{{ route('admin.verifikasi_afirmasi', $siswa) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            <input type="hidden" name="status" value="terverifikasi">
                                                            <button type="submit" 
                                                                class="font-bold py-1 px-3 rounded-md text-xs transition ease-in-out duration-150
                                                                    @if ($currentStatus == 'terverifikasi')
                                                                        bg-green-300 text-gray-700 cursor-not-allowed opacity-75
                                                                    @else
                                                                        bg-green-500 hover:bg-green-600 text-white
                                                                    @endif"
                                                                @if ($currentStatus == 'terverifikasi') disabled @endif>
                                                                Terima
                                                            </button>
                                                        </form>
                                                        
                                                        <form action="{{ route('admin.verifikasi_afirmasi', $siswa) }}" method="POST" class="inline-block ms-1">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="submit" 
                                                                class="font-bold py-1 px-3 rounded-md text-xs transition ease-in-out duration-150
                                                                    @if ($currentStatus == 'ditolak')
                                                                        bg-red-300 text-gray-700 cursor-not-allowed opacity-75
                                                                    @else
                                                                        bg-red-500 hover:bg-red-600 text-white
                                                                    @endif"
                                                                @if ($currentStatus == 'ditolak') disabled @endif>
                                                                Tolak
                                                            </button>
                                                        </form>
                                                        
                                                    @else
                                                        <span class="text-gray-400">Menunggu Unggahan</span>
                                                    @endif
                                                </td>
                                            @else
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $siswa->tanggal_lahir }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $siswa->nilai_akhir }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-red-600 font-bold">
                                                    {{ $siswa->jarak_ke_sekolah ?? $siswa->jarak_ke_sma_km }} KM
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection