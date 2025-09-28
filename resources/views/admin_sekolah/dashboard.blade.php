@extends('admin_sekolah.layouts.admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar Calon Murid Baru</h3>
                
                @if ($siswas->isEmpty())
                    <div class="text-center text-gray-500">
                        Belum ada siswa terdaftar dari sekolah Anda.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah Asal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalur Pendaftaran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($siswas as $siswa)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 mr-4">
                                                    @if ($siswa->foto)
                                                        <img class="h-10 w-10 rounded-full object-cover" 
                                                            src="{{ asset('storage/' . $siswa->foto) }}" 
                                                            alt="Foto {{ $siswa->user->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                                                            {{ strtoupper(substr($siswa->user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $siswa->user->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->jenis_kelamin }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->sekolahAsal->nama_sekolah }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->tanggal_lahir }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->jalurPendaftaran->nama_jalur_pendaftaran }}
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