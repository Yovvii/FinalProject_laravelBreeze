@extends('super_admin.layouts.super_admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Ringkasan Sistem</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
                        <p class="text-3xl font-bold">{{ $total_sekolah }}</p>
                        <p class="mt-2 text-sm">Total Sekolah Terdaftar</p>
                    </div>
                    <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
                        <p class="text-3xl font-bold">{{ $total_admin }}</p>
                        <p class="mt-2 text-sm">Total Akun Admin</p>
                    </div>
                    <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
                        <p class="text-3xl font-bold">{{ $total_siswa }}</p>
                        <p class="mt-2 text-sm">Total Siswa Terdaftar</p>
                    </div>
                </div>

                {{-- <div class="mt-8">
                    <h4 class="text-md font-semibold mb-3">Aksi Cepat</h4>
                    <a href="{{ route('super_admin.manajemen_sekolah') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                        Kelola Data Sekolah
                    </a>
                    <a href="{{ route('super_admin.manajemen_admin') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                        Kelola Akun Admin
                    </a>
                </div> --}}
                <div class="mt-8 p-6 bg-red-50 border border-red-200 rounded-lg">
                    <h3 class="text-xl font-bold text-red-700">PENGHENTIAN PROSES PPDB</h3>
                    <p class="mt-2 text-sm text-red-600">Fungsi ini akan menghentikan pendaftaran secara total dan menjalankan algoritma penentuan siswa diterima berdasarkan kuota dan peringkat di setiap SMA.</p>

                    <form method="POST" action="{{ route('super_admin.ppdb.stop') }}" onsubmit="return confirm('ANDA YAKIN INGIN MENGHENTIKAN PPDB? Aksi ini permanen dan akan menentukan siswa yang diterima.');">
                        @csrf
                        <button type="submit" class="mt-4 px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 disabled:opacity-50">
                            Hentikan & Tentukan Penerimaan
                        </button>
                    </form>

                    <form method="POST" action="{{ route('super_admin.spmb.reset') }}" onsubmit="return confirm('ANDA YAKIN INGIN MENGATUR ULANG SPMB? Ini akan menghapus semua status DITERIMA/DITOLAK dan memulai pendaftaran kembali.');" class="inline-block">
                        @csrf
                        <button type="submit" class="mt-4 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                            Mulai/Reset SPMB
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection