<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengaturan Profil - SPMB</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100">
    @include('layouts.notification')

    <div class="max-w-4xl mx-auto py-8 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('setelah.dashboard.show') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 font-poppins uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Pengaturan Profil Siswa</h2>
                <p class="mt-1 text-sm text-gray-600">Lihat dan perbarui data pendaftaran Anda di sini.</p>
            </div>

            <div class="p-6">
                {{-- Bagian Atas: Ringkasan Data Siswa --}}
                <div class="flex items-center space-x-6 border-b pb-6 mb-6">
                    <img src="{{ $siswa && $siswa->foto ? asset('storage/' . $siswa->foto) : asset('storage/profile_murid/avatar_empty.jpg') }}" alt="Foto Profil"
                        class="h-24 w-24 rounded-full object-cover shadow-lg">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">NISN: {{ $siswa->nisn ?? 'Belum ada' }}</p>
                        <p class="text-sm text-gray-500">Email: {{ $user->email }}</p>
                    </div>
                </div>

                {{-- Bagian Bawah: Tombol Navigasi Edit --}}
                <div class="space-y-4">
                    
                    {{-- Tombol Edit Biodata (Arahkan ke rute/fungsi yang memuat formulir Biodata Anda) --}}
                    @include('profile.partials.profile_action_menu', [
                        'title' => 'Biodata dan Data Orang Tua',
                        'description' => 'Nama lengkap, alamat, NIK, dan koordinat rumah.',
                        'editRoute' => 'profile.edit.biodata',
                        'resetRoute' => 'profile.reset.biodata',
                        'isRegistered' => $isRegistered,
                    ])

                    {{-- Tombol Edit Nilai --}}
                    @include('profile.partials.profile_action_menu', [
                        'title' => 'Nilai Rapor dan Mata Pelajaran',
                        'description' => 'Input nilai rapor semester 1 - 5 (jika diperlukan).',
                        'editRoute' => 'profile.edit.nilai',
                        'resetRoute' => 'profile.reset.nilai',
                        'isRegistered' => $isRegistered,
                    ])

                    {{-- Tombol Edit Dokumen --}}
                    @include('profile.partials.profile_action_menu', [
                        'title' => 'Dokumen Pendukung',
                        'description' => 'Akta lahir, SKL/Ijazah, dan dokumen lainnya.',
                        'editRoute' => 'profile.edit.dokumen',
                        'resetRoute' => 'profile.reset.dokumen',
                        'isRegistered' => $isRegistered,
                    ])

                </div>
            </div>
        </div>
    </div>
</body>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</html>