@extends('admin_sekolah.layouts.admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar Jalur Pendaftaran {{ Auth::user()->sma->nama_sma ?? '' }}</h3>
                
                <div class="flex space-x-4 mb-6">
                    @foreach ($jalurs as $jalur)
                        <a href="{{ route('admin.jalur_pendaftaran.show', $jalur->id) }}" class="px-4 py-2 rounded-md {{ request()->route('jalur_id') == $jalur->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                            {{ $jalur->nama_jalur_pendaftaran }}
                        </a>
                    @endforeach
                </div>
                
                <div class="flex mb-4 mt-6 justify-between content-center">
                    <h3 class="text-lg font-semibold">Daftar Siswa</h3>
                    @if ($jalur_id == 1)
                        <a href="{{ route('admin.sertifikat_murid') }}">
                            <p class="text-sm text-red-500 content-center hover:text-red-300">Pendaftar Dengan Sertifikat</p>
                        </a>
                    @endif
                </div>
                
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah Asal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                                    </tr>
                            </thead>
                            <tbody class="bg-gray-50">
                                @foreach ($siswas as $siswa)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="px-2 rounded-full w-fit
                                                @if ($siswa->verifikasi_sertifikat === 'terverifikasi')
                                                    bg-green-100 text-green-800 font-bold
                                                @else
                                                    text-gray-900 
                                                @endif">
                                                {{ $siswa->user->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->sekolahAsal->nama_sekolah }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->tanggal_lahir }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->nilai_akhir }}
                                        </td>
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