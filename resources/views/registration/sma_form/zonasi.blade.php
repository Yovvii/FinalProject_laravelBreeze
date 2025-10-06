<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="space-y-6"> 	
    {{-- Menghapus bagian Upload Dokumen KIP/PKH (Sesuai Permintaan "tanpa dokumen") --}}

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 border border-blue-200">
        <h3 class="font-bold text-gray-700 mb-4">Tandai Lokasi Rumah Anda</h3>
        <p class="text-sm text-gray-600 mb-3">Silakan **klik** atau **seret penanda (marker)** pada peta ke lokasi rumah Anda saat ini. Jarak ke sekolah akan dihitung berdasarkan titik ini saat Anda melanjutkan ke langkah berikutnya.</p>
        
        <div id="mapid" style="height: 400px;" class="rounded-lg mb-4"></div>
        
        <div class="flex space-x-4">
            {{-- Hidden Input yang akan menyimpan koordinat untuk form utama --}}
            <input type="hidden" name="lat_siswa" id="lat_siswa" value="{{ $siswa->latitude_siswa ?? '' }}">
            <input type="hidden" name="lng_siswa" id="lng_siswa" value="{{ $siswa->longitude_siswa ?? '' }}">

            <p class="text-sm text-gray-700">Koordinat Terpilih: <span id="coordinates" class="font-medium text-blue-600">
                {{ $siswa->latitude_siswa ? $siswa->latitude_siswa . ', ' . $siswa->longitude_siswa : 'Pilih lokasi di peta' }}
            </span></p>
        </div>
        
        @error('lat_siswa')
            <p class="mt-2 text-sm text-red-600">Lokasi rumah wajib ditentukan di peta.</p>
        @enderror
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- ULTIMATE SAFETY CHECK & MENGAMBIL REFERENSI INPUT YANG BENAR ---
        const mapContainer = document.getElementById('mapid');
        const latInput = document.getElementById('lat_siswa');
        const lngInput = document.getElementById('lng_siswa');
        const coordDisplay = document.getElementById('coordinates'); 

        if (!mapContainer || !latInput || !lngInput) {
            console.warn('Leaflet map initialization skipped: Required DOM elements (mapid, lat_siswa, or lng_siswa) not found.');
            return;
        }
        // --- END SAFETY CHECK ---
        
        // Koordinat Default (Purbalingga)
        var PURBALINGGA_LAT = -7.3768; 
        var PURBALINGGA_LNG = 109.3809;
        
        // Ambil data koordinat siswa dari PHP.
        var phpLatString = '{{ $siswa->latitude_siswa ?? '' }}'; 
        var phpLngString = '{{ $siswa->longitude_siswa ?? '' }}';

        var initialLat, initialLng;

        // Tentukan koordinat awal
        if (phpLatString && phpLatString != 0) {
            initialLat = parseFloat(phpLatString);
            initialLng = parseFloat(phpLngString);
        } else {
            // Gunakan Purbalingga jika koordinat dari database kosong/null (entri baru)
            initialLat = PURBALINGGA_LAT;
            initialLng = PURBALINGGA_LNG;

            // Kosongkan input form
            latInput.value = '';
            lngInput.value = '';
            coordDisplay.textContent = 'Pilih lokasi di peta';
        }

        // Inisialisasi Peta
        var map = L.map('mapid').setView([initialLat, initialLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker Rumah Siswa (Dibuat draggable)
        var homeMarker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map).bindPopup("Lokasi Rumah Anda").openPopup();

        // Fungsi untuk mengupdate input dan tampilan (TIDAK ADA LOGIKA AJAX/SIMPAN OTOMATIS)
        function updateInputs(lat, lng) {
            const formattedLat = lat.toFixed(6);
            const formattedLng = lng.toFixed(6);
            
            latInput.value = formattedLat;
            lngInput.value = formattedLng;
            coordDisplay.textContent = `${formattedLat}, ${formattedLng}`;
        }

        // Update saat marker digeser
        homeMarker.on('dragend', function (event) {
            var position = event.target.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        // Update saat peta diklik
        map.on('click', function (e) {
            homeMarker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        // --- FIX PETA PUTIH ---
        // Digunakan jika peta dimuat dalam elemen yang awalnya tersembunyi (misalnya tab, langkah form)
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
        // --- END FIX ---


        // Jika ada data awal, pastikan input dan tampilan terisi
        if (phpLatString && phpLatString != 0) {
            updateInputs(initialLat, initialLng);
        }
    });
</script>