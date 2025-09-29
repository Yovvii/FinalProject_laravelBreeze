@extends('admin_sekolah.layouts.admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Verifikasi Dokumen Afirmasi Siswa</h3>
                
                @if (session('berhasil'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('berhasil') }}
                    </div>
                @endif

                @if ($siswas->isEmpty())
                    <div class="text-center text-gray-500">
                        Belum ada siswa Jalur Afirmasi yang mengunggah dokumen KIP/PKH.
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
                                        Dokumen Afirmasi (KIP/PKH)
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
                                        {{-- Asumsi Anda memiliki relasi 'sekolahAsal' pada Model Siswa --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $siswa->sekolahAsal->nama_sekolah ?? 'N/A' }}
                                        </td>
                                        
                                        {{-- DOKUMEN AFIRMASI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($siswa->document_afirmasi)
                                                <a href="{{ Storage::url($siswa->document_afirmasi) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                Tidak Ada
                                            @endif
                                        </td>
                                        
                                        {{-- STATUS VERIFIKASI AFIRMASI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($siswa->verifikasi_afirmasi === 'terverifikasi')
                                                    bg-green-100 text-green-800
                                                @elseif ($siswa->verifikasi_afirmasi === 'ditolak')
                                                    bg-red-100 text-red-800
                                                @else
                                                    bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($siswa->verifikasi_afirmasi ?? 'Pending') }}
                                            </span>
                                        </td>
                                        
                                        {{-- AKSI VERIFIKASI AFIRMASI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            @if (($siswa->verifikasi_afirmasi === 'pending' || $siswa->verifikasi_afirmasi === 'ditolak' || is_null($siswa->verifikasi_afirmasi)) && $siswa->document_afirmasi)
                                                <form action="{{ route('admin.verifikasi_afirmasi', $siswa) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status" value="terverifikasi">
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Verifikasi</button>
                                                </form>
                                            @endif
                                            
                                            @if (($siswa->verifikasi_afirmasi === 'pending' || $siswa->verifikasi_afirmasi === 'terverifikasi' || is_null($siswa->verifikasi_afirmasi)) && $siswa->document_afirmasi)
                                                <form action="{{ route('admin.verifikasi_afirmasi', $siswa) }}" method="POST" class="inline-block ms-2">
                                                    @csrf
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                                </form>
                                            @endif
                                            @if (!$siswa->document_afirmasi)
                                                <span class="text-gray-400">Menunggu Unggahan</span>
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