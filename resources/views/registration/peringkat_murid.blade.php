<x-app-layout>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center w-full bg-gray-50 pb-3 border-b">Peringkat Sementara</h2>

                @if (session('berhasil'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('berhasil') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-100 p-4 rounded-lg shadow-sm text-center">
                        <p class="text-sm font-medium text-blue-600">SMA Tujuan</p>
                        <p class="text-xl font-bold text-gray-800">{{ $siswa->dataSma->nama_sma ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-lg shadow-sm text-center">
                        <p class="text-sm font-medium text-blue-600">Jalur Pendaftaran</p>
                        <p class="text-xl font-bold text-gray-800">{{ $siswa->jalurPendaftaran->nama_jalur_pendaftaran ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg shadow-sm text-center">
                        <p class="text-sm font-medium text-green-600">Peringkat Anda</p>
                        <p class="text-xl font-extrabold text-green-800">{{ $peringkatSiswa }} / {{ $totalPendaftar }}</p>
                    </div>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-4">Detail Peringkat (Jalur {{ $siswa->jalurPendaftaran->nama_jalur_pendaftaran ?? '' }})</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                @if ($siswa->jalur_pendaftaran_id == 3 || $siswa->jalur_pendaftaran_id == 2)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak (KM)</th>
                                @else
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Rata-rata</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($allSiswas as $index => $pendaftar)
                                <tr @if ($pendaftar->id === $siswa->id) class="bg-yellow-50 font-bold" @endif>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 flex items-center gap-x-1">
                                        {{ $pendaftar->user->name }} 
                                        @if ($pendaftar->verifikasi_sertifikat === 'terverifikasi')
                                            <div class="bg-green-500 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="white" class="size-4">
                                                    <path d="M6 6v4h4V6H6Z" />
                                                    <path fill-rule="evenodd" d="M5.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3a2 2 0 0 0 2 2v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13a2 2 0 0 0 2-2h1.25a.75.75 0 0 0 0-1.5H13v-.75h1.25a.75.75 0 0 0 0-1.5H13V6.5h1.25a.75.75 0 0 0 0-1.5H13a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-.75V1.75a.75.75 0 0 0-1.5 0V3H6.5V1.75A.75.75 0 0 0 5.75 1ZM11 4.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V5a.5.5 0 0 1 .5-.5h6Z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                        @if ($pendaftar->id === $siswa->id) (Anda) @endif
                                    </td>
                                    @if ($siswa->jalur_pendaftaran_id == 3 || $siswa->jalur_pendaftaran_id == 2)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pendaftar->jarak_ke_sma_km }} KM</td>
                                    @else
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pendaftar->nilai_akhir }}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d F Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($pendaftar->id === $siswa->id)
                                            {{-- Aksi untuk Siswa yang Sedang Login (Tarik Berkas) --}}
                                            <form action="{{ route('siswa.tarik_berkas') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menarik semua berkas pendaftaran? Aksi ini akan menghapus pilihan SMA, jalur, dan semua berkas yang telah diunggah. Anda harus mendaftar dari awal.');">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                                    Tarik Berkas
                                                </button>
                                            </form>
                                        @else
                                            {{-- Aksi untuk Siswa Lain (Lihat Data) --}}
                                            <button 
                                                onclick="showSiswaDetail({{ 
                                                    // JSON ENCODE DATA SISWA LAIN UNTUK DITAMPILKAN DI CARD
                                                    json_encode([
                                                        'nama' => $pendaftar->user->name,
                                                        'sekolah_asal' => $pendaftar->sekolahAsal->nama_sekolah ?? 'N/A',
                                                        'tanggal_lahir' => \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d F Y'),
                                                        'usia' => floor(\Carbon\Carbon::parse($pendaftar->tanggal_lahir)->diffInYears(\Carbon\Carbon::now())),
                                                        'agama' => $pendaftar->agama,
                                                        'nilai_akhir' => $pendaftar->nilai_akhir,
                                                        'jenis_kelamin' => $pendaftar->jenis_kelamin,
                                                    ]) 
                                                }})" 
                                                class="text-blue-600 hover:text-blue-900 font-medium">
                                                Lihat Data
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @php
                    $totalSiswaTerverifikasi = $allSiswas->filter(function ($siswa) {
                        return $siswa->verifikasi_sertifikat === 'terverifikasi';
                    })->count();
                @endphp

                <div class="mt-8 text-sm text-gray-500">
                    <p> Ketetarangan : <br>
                        - Peringkat dihitung berdasarkan kriteria seleksi jalur {{ $siswa->jalurPendaftaran->nama_jalur_pendaftaran ?? '' }} (Nilai Akhir dan Usia untuk Prestasi, Jarak dan Usia untuk Zonasi/Afirmasi).
                    </p>                    
                    <div class="flex items-center gap-x-1">
                    @if ($totalSiswaTerverifikasi > 0)
                    -   <div class="bg-green-500 rounded-md w-fit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="white" class="size-4">
                                <path d="M6 6v4h4V6H6Z" />
                                <path fill-rule="evenodd" d="M5.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3v.75H1.75a.75.75 0 0 0 0 1.5H3a2 2 0 0 0 2 2v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13h.75v1.25a.75.75 0 0 0 1.5 0V13a2 2 0 0 0 2-2h1.25a.75.75 0 0 0 0-1.5H13v-.75h1.25a.75.75 0 0 0 0-1.5H13V6.5h1.25a.75.75 0 0 0 0-1.5H13a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-.75V1.75a.75.75 0 0 0-1.5 0V3H6.5V1.75A.75.75 0 0 0 5.75 1ZM11 4.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V5a.5.5 0 0 1 .5-.5h6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="font-bold">
                            <span class="text-green-600">Total Siswa Terverifikasi Sertifikat:</span> {{ $totalSiswaTerverifikasi }} siswa
                        </p>
                    @endif
                    </div>
                </div>

                @if ($siswa->jalur_pendaftaran_id == 2)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 mt-3">
                            <thead class="bg-blue-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak (KM)</th>                              
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>                             
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Dokumen</th>                             
                                </tr>
                            </thead>
                            <tbody class="bg-blue-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($siswa->verifikasi_afirmasi === 'terverifikasi')
                                                {{ $index + 1 }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->jarak_ke_sma_km }} KM</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nilai_akhir }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <p class="w-fit rounded-full px-2 font-extrabold
                                                @switch($siswa->verifikasi_afirmasi)
                                                    @case('terverifikasi')
                                                        bg-green-100 text-green-800
                                                        @break

                                                    @case('pending')
                                                        bg-yellow-100 text-yellow-800
                                                        @break

                                                    @case('ditolak')
                                                        bg-red-100 text-red-800
                                                        @break

                                                    @default
                                                        bg-gray-100 text-gray-600
                                                @endswitch
                                        ">{{ $siswa->verifikasi_afirmasi }} </p>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                <div id="siswaDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        
                        <h3 class="text-xl font-bold mb-4 border-b pb-2">Detail Calon Siswa</h3>

                        <div id="siswaDetailContent">
                            {{-- Content will be populated by JavaScript --}}
                        </div>

                        <div class="mt-6 text-right">
                            <button onclick="document.getElementById('siswaDetailModal').classList.add('hidden')" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function showSiswaDetail(data) {
                        const content = document.getElementById('siswaDetailContent');
                        const modal = document.getElementById('siswaDetailModal');
                        
                        let htmlContent = `
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between border-b border-gray-100 pb-1">
                                    <span class="font-medium">Nama</span>
                                    <span>${data.nama}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-1">
                                    <span class="font-medium">Sekolah Asal</span>
                                    <span>${data.sekolah_asal}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-1">
                                    <span class="font-medium">Jenis Kelamin</span>
                                    <span>${data.jenis_kelamin}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-1">
                                    <span class="font-medium">Agama</span>
                                    <span>${data.agama}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-1">
                                    <span class="font-medium">Tgl Lahir</span>
                                    <span>${data.tanggal_lahir}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-1">
                                    <span class="font-medium">Usia</span>
                                    <span>${data.usia} tahun</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-1">
                                    <span class="font-medium">Nilai Akhir Rata-rata</span>
                                    <span class="font-bold text-blue-700">${data.nilai_akhir}</span>
                                </div>
                            </div>
                        `;

                        content.innerHTML = htmlContent;
                        modal.classList.remove('hidden');
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>