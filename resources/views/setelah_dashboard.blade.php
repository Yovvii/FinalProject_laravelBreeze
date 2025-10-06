<x-app-layout>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <div class="text-center mb-10">
                    <div class="bg-blue-50 h-60 flex items-center justify-center rounded-lg border-4 border-blue-200">
                        <p class="text-blue-700 font-bold text-xl">BANNER INFORMASI</p>
                    </div>
                </div>
                
                <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-8">
                    Sistem Pendaftaran PPDB 2024/2025
                </h1>

                <div class="text-gray-700 space-y-4 p-4 border border-gray-100 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Rangkuman Pendaftaran Anda</h3>
                    
                    <p>
                        <span class="font-bold w-48 inline-block">Sekolah Tujuan:</span> 
                        <span class="text-blue-700">{{ $siswa->dataSma->nama_sma ?? 'N/A' }}</span>
                    </p>
                    
                    <p>
                        <span class="font-bold w-48 inline-block">Jalur Pendaftaran:</span> 
                        <span class="text-blue-700">{{ $siswa->jalurPendaftaran->nama_jalur_pendaftaran ?? 'N/A' }}</span>
                    </p>

                    <h3 class="text-xl font-semibold mt-6 text-gray-800 border-b pb-2 pt-4">Informasi Penting</h3>
                    <p>
                        Untuk memantau status verifikasi dokumen atau melihat kelengkapan berkas, silakan gunakan menu navigasi utama untuk menuju halaman **Timeline Pendaftaran SMA**.
                    </p>
                    <p>
                        Jika Anda ingin membatalkan pendaftaran dan memilih sekolah lain, Anda harus melakukan proses **Penarikan Berkas** melalui laman Timeline Pendaftaran SMA.
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>