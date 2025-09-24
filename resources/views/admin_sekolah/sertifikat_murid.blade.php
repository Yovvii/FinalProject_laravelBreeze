@extends('admin_sekolah.layouts.admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Verifikasi Sertifikat Siswa</h3>
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($siswas->isEmpty())
                    <div class="text-center text-gray-500">
                        Belum ada siswa yang mengunggah sertifikat.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Siswa
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sekolah Asal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sertifikat
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status Verifikasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($siswas as $siswa)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $siswa->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->sekolahAsal->nama_sekolah }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($siswa->sertifikat_file)
                                                <a href="{{ Storage::url($siswa->sertifikat_file) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Sertifikat</a>
                                            @else
                                                Tidak Ada
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($siswa->verifikasi_sertifikat === 'terverifikasi')
                                                    bg-green-100 text-green-800
                                                @elseif ($siswa->verifikasi_sertifikat === 'ditolak')
                                                    bg-red-100 text-red-800
                                                @else
                                                    bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($siswa->verifikasi_sertifikat) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            @if ($siswa->verifikasi_sertifikat === 'pending' || $siswa->verifikasi_sertifikat === 'ditolak')
                                                <form action="{{ route('admin.verifikasi_sertifikat', $siswa) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status" value="terverifikasi">
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Verifikasi</button>
                                                </form>
                                            @endif
                                            @if ($siswa->verifikasi_sertifikat === 'pending' || $siswa->verifikasi_sertifikat === 'terverifikasi')
                                                <form action="{{ route('admin.verifikasi_sertifikat', $siswa) }}" method="POST" class="inline-block ms-2">
                                                    @csrf
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                                </form>
                                            @endif
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