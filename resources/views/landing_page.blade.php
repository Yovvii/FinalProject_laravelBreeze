<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Selamat Datang SPMB</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-max-screen w-max-screen">
    @include('layouts.notification')
    <div class="p-3 h-screen flex gap-x-3">
        <div class="bg-cover bg-center text-white w-[70%] rounded-3xl px-5 py-3 flex flex-col justify-between [box-shadow:inset_0_-180px_100px_0px_rgba(0,0,0,0.5)]"
        style="background-image: url('/assets/banner/banner1.jpg')">
            <div class="flex justify-between">
                <p>SPMB Kabupaten Purbalingga</p>
                <p class="w-[77%] border-b"></p>
            </div>
            <p class="font-montaga text-[56px]/[65px] mb-[3%] text-white/90">Sekolah Hebat <br> Ciptakan Generasi Hebat <br>
                <span class="inline-block text-[20px]/[24px] font-poppins w-[70%] mt-3">Sistem Penerimaan Murid Baru (SPMB) adalah proses resmi yang diselenggarakan oleh lembaga pendidikan untuk menjaring calon peserta didik yang ingin melanjutkan studi ke jenjang berikutnya.</span>
            </p>
        </div>
        <div class="flex flex-col bg-white text-white w-[30%] px-[3%] content-center" x-data="{ currentView: 'login', showAdminOptions: false }">
            <div class="">
                <img src="/assets/logo_dummy.png" alt=""
                class="w-[30%] mx-auto mb-[15%]">
            </div>

            <div class="">
                <template x-if="currentView === 'login'">
                    <div x-show="currentView === 'login'">
                        @include('auth.login') 
                    </div>
                </template>

                <template x-if="currentView === 'register'">
                    <div x-show="currentView === 'register'">
                        @include('auth.register')
                        <p class="text-[14px] text-center mt-5 text-black">
                            <span @click="showAdminOptions = !showAdminOptions" class="underline cursor-pointer font-medium text-gray-500 hover:text-gray-700">
                                Atau Login Sebagai?
                            </span>
                        </p>
                    </div>
                </template>
            </div>

            <div x-show="showAdminOptions" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="px-4 py-1 border border-gray-200 bg-white rounded-xl text-center absolute bottom-[10%] right-[6%]">

                <p class="text-sm font-semibold mb-3 text-black">Pilih Jenis Admin</p>
                
                <div class="flex justify-center space-x-3">
                    {{-- Tombol Login Super Admin --}}
                    <a href="{{ route('superadmin.login.form') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-full shadow-md">
                        Super Admin
                    </a>
                    
                    {{-- Tombol Login Admin Sekolah --}}
                    <a href="{{ route('admin.login') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-full shadow-md">
                        Admin Sekolah
                    </a>
                </div>
                
                <a href="#" @click.prevent="showAdminOptions = false" class="mt-3 block text-xs text-gray-500 hover:text-gray-900 underline">
                    Kembali ke Login Siswa
                </a>
            </div>
        </div>
    </div>
</body>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</html>