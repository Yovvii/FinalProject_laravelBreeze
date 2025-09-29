<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="space-y-6"> 	
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-200">
        <div class="border bg-blue-100 p-4 rounded-lg">
            <p>Upload Document</p>
            <span class="font-bold">KIP/PKH</span>
            
            <div class="space-y-5 my-7">
                <div class="sm:col-span-3 relative px-2 pt-3 border bg-white rounded-lg">
                    <label for="document_afirmasi" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload KIP/PKH Wajib</label>
                    <input type="file" name="document_afirmasi" id="document_afirmasi" 
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none" accept="application/pdf">
                    
                    {{-- @if (isset($siswa->document_afirmasi) && $siswa->document_afirmasi)
                        <div class="bg-green-500 rounded-full w-5 absolute right-3 top-5">
                            <svg class="check-akta" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
                        </div>
                    @endif --}}
                </div>

                @if (isset($siswa->document_afirmasi) && $siswa->document_afirmasi)
                    <div class="mt-2 text-sm text-blue-600">
                        File terunggah: <a href="{{ Storage::url($siswa->document_afirmasi) }}" target="_blank" class="underline">Lihat Dokumen</a>
                    </div>
                @endif

                @error('document_afirmasi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 border border-blue-200">
        <h3 class="font-bold text-gray-700 mb-4">Tandai Lokasi Rumah Anda</h3>
        <p class="text-sm text-gray-600 mb-3">Silakan klik atau seret penanda (marker) pada peta ke lokasi rumah Anda saat ini. Jarak ke sekolah akan dihitung berdasarkan titik ini.</p>
        
        <div id="mapid" style="height: 400px;" class="rounded-lg mb-4"></div>
        
        <div class="flex space-x-4">
            {{-- ID INPUT YANG BENAR ADALAH lat_siswa dan lng_siswa --}}
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
        const latInput = document.getElementById('lat_siswa'); // !!! PERBAIKAN: Gunakan ID yang benar
        const lngInput = document.getElementById('lng_siswa'); // !!! PERBAIKAN: Gunakan ID yang benar
        const coordDisplay = document.getElementById('coordinates'); // Untuk menampilkan koordinat

        if (!mapContainer || !latInput || !lngInput) {
            console.warn('Leaflet map initialization skipped: Required DOM elements (mapid, lat_siswa, or lng_siswa) not found.');
            return;
        }
        // --- END SAFETY CHECK ---
        
        // Koordinat Alun-Alun Purbalingga sebagai default
        var PURBALINGGA_LAT = -7.3768; 
        var PURBALINGGA_LNG = 109.3809;
        
        // Ambil data koordinat siswa dari PHP. Jika kosong, gunakan default Purbalingga.
        var phpLatString = '{{ $siswa->latitude_siswa ?? '' }}'; 
        var phpLngString = '{{ $siswa->longitude_siswa ?? '' }}';

        var defaultLat, defaultLng;

        // Tentukan koordinat awal
        if (phpLatString && phpLatString != 0) {
            defaultLat = parseFloat(phpLatString);
            defaultLng = parseFloat(phpLngString);
        } else {
            // Gunakan Purbalingga jika koordinat dari database kosong/null (entri baru)
            defaultLat = PURBALINGGA_LAT;
            defaultLng = PURBALINGGA_LNG;

             // Kosongkan input form
             latInput.value = '';
             lngInput.value = '';
             coordDisplay.textContent = 'Pilih lokasi di peta';
        }

        // Inisialisasi Peta
        var map = L.map('mapid').setView([defaultLat, defaultLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker Rumah Siswa (Dibuat draggable)
        var homeMarker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map).bindPopup("Lokasi Rumah Anda").openPopup();

        // Fungsi untuk mengupdate input dan tampilan
        function updateInputs(lat, lng) {
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);
            coordDisplay.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }

        // Update saat marker digeser
        homeMarker.on('dragend', function (event) {
            var marker = event.target;
            var position = marker.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        // Update saat peta diklik
        map.on('click', function (e) {
            homeMarker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        // --- FIX PETA PUTIH ---
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
        // --- END FIX ---


        // Jika ada data awal, pastikan input dan tampilan terisi
        if (phpLatString && phpLatString != 0) {
            updateInputs(defaultLat, defaultLng);
        }
    });
</script>