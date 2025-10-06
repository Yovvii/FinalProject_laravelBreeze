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
        <div class="bg-white text-white w-[30%] px-[3%] content-center" x-data="{ currentView: 'login' }">
            <template x-if="currentView === 'login'">
                <div x-show="currentView === 'login'">
                    @include('auth.login') 
                </div>
            </template>

            <template x-if="currentView === 'register'">
                <div x-show="currentView === 'register'">
                    @include('auth.register')
                </div>
            </template>
        </div>
    </div>
</body>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</html>