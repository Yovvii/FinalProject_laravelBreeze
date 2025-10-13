<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Biodata Siswa - SPMB</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Link CSS Leaflet (Wajib Ada) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('profile.settings') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Pengaturan
            </a>
        </div>

        <form method="POST" action="{{ route('profile.update.biodata') }}" enctype="multipart/form-data">
            @csrf
            @method('POST') {{-- Gunakan POST, tetapi pastikan route Anda juga POST --}}

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h1 class="text-2xl font-bold mb-6 border-b pb-2">Edit Data Biodata & Lokasi</h1>

                {{-- Tempatkan SELURUH KONTEN dari biodata.blade.php di sini --}}
                @include('account.timeline_form.biodata', ['siswa' => $siswa, 'ortu' => $ortu, 'user' => $user])
                {{-- ASUMSI: Anda memindahkan konten body biodata.blade.php ke komponen/partial.
                   Jika tidak, tempelkan seluruh konten biodata.blade.php (tanpa @push/extends) di sini --}}

                <div class="flex justify-end mt-8">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                        Simpan Perubahan Biodata
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Script Leaflet (Wajib Ada) --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Script Map (Ambil seluruh konten dari @push('scripts') di biodata.blade.php) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Nilai awal dari input (Telah diperbaiki di langkah sebelumnya)
            var defaultLat = parseFloat(document.getElementById('latitude').value) || -7.3690; 
            var defaultLng = parseFloat(document.getElementById('longitude').value) || 109.3496;

            // Inisialisasi Peta
            var map = L.map('mapid').setView([defaultLat, defaultLng], 13);

            // Tile Layer (Map Tampilan)
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Tambahkan Penanda (Marker)
            var marker = L.marker([defaultLat, defaultLng], {
                draggable: true // Membuat penanda bisa diseret
            }).addTo(map);

            // Fungsi Update Koordinat
            function updateCoordinates(lat, lng) {
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
            }

            // Event saat Penanda diseret
            marker.on('dragend', function (e) {
                var coords = e.target.getLatLng();
                updateCoordinates(coords.lat, coords.lng);
            });

            // Event saat Peta diklik
            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updateCoordinates(e.latlng.lat, e.latlng.lng);
            });
            
            // Inisialisasi awal nilai input
            updateCoordinates(defaultLat, defaultLng);

            // FIX UTAMA: memastikan peta menyesuaikan diri
            setTimeout(function () {
                map.invalidateSize();
            }, 300);
        });
    </script>
</body>
</html>