<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai Siswa - SPMB</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('profile.settings') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Pengaturan
            </a>
        </div>

        <form method="POST" action="{{ route('profile.update.nilai') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h1 class="text-2xl font-bold mb-6 border-b pb-2">Edit Data Nilai Rapor</h1>

                {{-- 💡 INCLUDE KONTEN FORM NILAI Rapor DARI VIEW ASLI ANDA --}}
                @include('account.timeline_form.rapor', ['siswa' => $siswa, 'mapels' => $mapels, 'semesters' => $semesters, 'allSemesters' => $allSemesters])
                
                {{-- ASUMSI: File form nilai Anda bernama nilai_rapor.blade.php. 
                   Jika file aslinya bernama lain, ganti 'nilai_rapor' dengan nama file yang benar. --}}

                <div class="flex justify-end mt-8">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                        Simpan Perubahan Nilai
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>