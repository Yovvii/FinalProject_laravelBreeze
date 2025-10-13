<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokumen Siswa - SPMB</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-8 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('profile.settings') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Pengaturan
            </a>
        </div>

        <form method="POST" action="{{ route('profile.update.dokumen') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 space-y-8">
                <h1 class="text-2xl font-bold border-b pb-2">Edit Dokumen Penting</h1>
                
                {{-- Tampilkan pesan error global (penting untuk kegagalan validasi file) --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Gagal menyimpan!</strong> Periksa kolom yang ditandai merah.
                    </div>
                @endif

                {{-- 💡 INCLUDE FORM SURAT PERNYATAAN --}}
                {{-- Sesuaikan nama view ini jika berbeda --}}
                @include('account.timeline_form.surat_pernyataan', ['siswa' => $siswa]) 

                {{-- 💡 INCLUDE FORM SURAT KETERANGAN LULUS & IJAZAH --}}
                {{-- Sesuaikan nama view ini jika berbeda --}}
                @include('account.timeline_form.surat_keterangan_lulus', ['siswa' => $siswa])

                <div class="flex justify-end pt-4 border-t">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition">
                        Simpan Perubahan Dokumen
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>