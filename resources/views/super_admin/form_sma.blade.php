@extends('super_admin.layouts.super_admin_layout')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($sma) ? 'Edit Data Sekolah' : 'Tambah Data Sekolah' }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ isset($sma) ? route('super_admin.sma.update', $sma) : route('super_admin.sma.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($sma))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="nama_sma" class="block text-gray-700 text-sm font-bold mb-2">Nama Sekolah</label>
                        <input type="text" name="nama_sma" id="nama_sma" value="{{ old('nama_sma', $sma->nama_sma ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('nama_sma')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="akreditasi_id" class="block text-gray-700 text-sm font-bold mb-2">Akreditasi</label>
                        <select name="akreditasi_id" id="akreditasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @foreach ($akreditasis as $akreditasi)
                                <option value="{{ $akreditasi->id }}" @if(isset($sma) && $sma->akreditasi_id == $akreditasi->id) selected @endif>
                                    {{ $akreditasi->jenis_akreditasi }}
                                </option>
                            @endforeach
                        </select>
                        @error('akreditasi_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="kuota_siswa" class="block text-gray-700 text-sm font-bold mb-2">Kuota Siswa (Angka)</label>
                        <input type="number" name="kuota_siswa" id="kuota_siswa" 
                            value="{{ old('kuota_siswa', $sma->kuota_siswa ?? 0) }}" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            min="0" required>
                        @error('kuota_siswa')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 border p-4 rounded-lg bg-gray-50">
                        <h4 class="font-bold text-gray-800 mb-3">Koordinat Lokasi Sekolah (Wajib untuk Jalur Afirmasi)</h4>
                        <p class="text-sm text-gray-600 mb-4">Silakan seret penanda (marker) di peta ke lokasi sekolah yang akurat. Koordinat akan otomatis terisi.</p>

                        <div class="flex space-x-4 mb-4">
                            <div>
                                <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude</label>
                                <input type="text" name="latitude" id="latitude" 
                                    value="{{ old('latitude', $sma->latitude ?? '') }}" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    readonly required>
                                @error('latitude')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude</label>
                                <input type="text" name="longitude" id="longitude" 
                                    value="{{ old('longitude', $sma->longitude ?? '') }}" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    readonly required>
                                @error('longitude')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="mapid" style="height: 350px;" class="rounded-lg shadow-inner border border-gray-300"></div>
                    </div>
                    <div class="mb-4">
                        <label for="logo_sma" class="block text-gray-700 text-sm font-bold mb-2">Logo Sekolah</label>
                        <input type="file" name="logo_sma" id="logo_sma" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('logo_sma')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                        @if(isset($sma) && $sma->logo_sma)
                            <p class="text-sm text-gray-500 mt-2">Logo saat ini:</p>
                            <img src="{{ Storage::url($sma->logo_sma) }}" alt="Logo Sekolah" class="w-20 h-20 mt-2">
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ isset($sma) ? 'Perbarui' : 'Simpan' }}
                        </button>
                        <a href="{{ route('super_admin.data_sma') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Koordinat Alun-Alun Purbalingga sebagai default
            var PURBALINGGA_LAT = -7.3768; 
            var PURBALINGGA_LNG = 109.3809;
            
            // Ambil data koordinat dari PHP sebagai string berkuotasi, atau string kosong jika null.
            // Kita akan konversi ke float di JavaScript.
            var phpLatString = '{{ $sma->latitude ?? '' }}';
            var phpLngString = '{{ $sma->longitude ?? '' }}';

            var defaultLat, defaultLng;

            // Cek apakah string koordinat dari PHP valid
            if (phpLatString && phpLatString != 0) {
                defaultLat = parseFloat(phpLatString);
                defaultLng = parseFloat(phpLngString);
            } else {
                // Gunakan Purbalingga jika koordinat dari database kosong/null
                defaultLat = PURBALINGGA_LAT;
                defaultLng = PURBALINGGA_LNG;

                    // Pastikan input form dikosongkan jika ini adalah entri baru
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
            }

            // Inisialisasi Peta
            // PENTING: Leaflet mengharapkan angka (Float), yang sudah dipastikan di atas
            var map = L.map('mapid').setView([defaultLat, defaultLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Marker Sekolah (Dibuat draggable)
            var schoolMarker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map).bindPopup("Lokasi Sekolah").openPopup();

            // Fungsi untuk mengupdate input
            function updateInputs(lat, lng) {
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
            }

            // Update saat marker digeser
            schoolMarker.on('dragend', function (event) {
                var marker = event.target;
                var position = marker.getLatLng();
                updateInputs(position.lat, position.lng);
            });

            // Update saat peta diklik
            map.on('click', function (e) {
                schoolMarker.setLatLng(e.latlng);
                updateInputs(e.latlng.lat, e.latlng.lng);
            });

            // --- FIX PETA PUTIH ---
            // Memaksa Leaflet menghitung ulang ukuran kontainer setelah dimuat
            setTimeout(function() {
                if (map) {
                    map.invalidateSize();
                }
            }, 300);
            // --- END FIX ---


            // Jika ada data awal, pastikan input terisi, jika tidak, biarkan kosong (sudah dikosongkan di atas)
            if (phpLatString && phpLatString != 0) {
                updateInputs(defaultLat, defaultLng);
            }
        });
    </script>
@endsection