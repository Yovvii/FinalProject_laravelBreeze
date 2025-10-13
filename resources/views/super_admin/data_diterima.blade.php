@extends('super_admin.layouts.super_admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($spmb_status !== 'closed')
                    {{-- 1. TAMPILAN JIKA SESI BELUM BERAKHIR --}}
                    <div class="p-6 text-center bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h3 class="mt-2 text-xl font-bold">Sesi Pendaftaran Belum Berakhir</h3>
                        <p class="mt-1 text-sm">
                            Hasil akhir siswa yang diterima baru akan ditampilkan setelah Super Admin menghentikan proses PPDB.
                        </p>
                    </div>

                @else
                    {{-- 2. TAMPILAN JIKA SESI SUDAH DITUTUP (CLOSED) --}}
                    <h3 class="text-2xl font-bold mb-4">Daftar Siswa Yang Diterima</h3>
                    <form method="GET" action="{{ request()->url() }}" class="mb-4 bg-gray-50 p-4 rounded-lg shadow-inner">
                        <div class="flex flex-wrap items-end space-y-4 md:space-y-0 md:space-x-4">
                            
                            {{-- Filter Sekolah --}}
                            <div class="w-full sm:w-1/2 lg:w-1/3">
                                <label for="sma_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Sekolah (SMA)</label>
                                <select name="sma_id" id="sma_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">-- Semua Sekolah --</option>
                                    @foreach ($smas as $sma)
                                        <option value="{{ $sma->id }}" {{ $filterSmaId == $sma->id ? 'selected' : '' }}>
                                            {{ $sma->nama_sma }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Jalur --}}
                            <div class="w-full sm:w-1/2 lg:w-1/3">
                                <label for="jalur_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Jalur</label>
                                <select name="jalur_id" id="jalur_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">-- Semua Jalur --</option>
                                    @foreach ($jalurs as $jalur)
                                        <option value="{{ $jalur->id }}" {{ $filterJalurId == $jalur->id ? 'selected' : '' }}>
                                            {{ $jalur->nama_jalur_pendaftaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Tombol Aksi --}}
                            <div class="w-full lg:w-auto flex space-x-2">
                                <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Filter
                                </button>
                                @if ($filterSmaId || $filterJalurId)
                                    <a href="{{ request()->url() }}" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    @if ($siswasDiterima->isEmpty())
                        <div class="p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 rounded-lg">
                            <p class="font-semibold">Tidak ada siswa yang berstatus 'Diterima' saat ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diterima di SMA</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($siswasDiterima as $index => $siswa)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $siswasDiterima->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $siswa->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->nisn }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-700 font-semibold">
                                                {{ $siswa->dataSma->nama_sma ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->jalurPendaftaran->nama_jalur_pendaftaran ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->nilai_akhir }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $siswa->jarak_ke_sma_km ?? '-' }} <span class="font-black text-black">KM</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $siswasDiterima->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection