@extends('admin_sekolah.layouts.admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-semibold mb-4">
                    Peringkat Akhir Siswa Jalur {{ $jalurs->firstWhere('id', $jalur_id)->nama_jalur_pendaftaran ?? 'Pendaftaran' }} {{ Auth::user()->sma->nama_sma ?? '' }}
                </h3>

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
                        <table class="min-w-full divide-y divide-gray-200">
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
                            
                            {{-- Isi Tabel --}}
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($siswas as $siswa)
                                    <tr class="
                                        @if ($jalur_id == 1 && $siswa->verifikasi_sertifikat == 'terverifikasi') 
                                            bg-green-100
                                        @else 
                                            hover:bg-gray-50 
                                        @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-center text-blue-600">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $siswa->user->name }}
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
                @endif
            </div>
        </div>
    </div>
@endsection