{{-- Data Siswa --}}
<div class="border border-gray-400 p-6 rounded-lg">
    <div>
        Data <span class="font-bold">Calon Murid Baru</span>
    </div>

    <div class="space-y-10">
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
            
            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="name" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg flex">
                @if (isset($siswa->foto) && $siswa->foto)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Profile" class="max-w-40 max-h-10 rounded-full shadow-md">
                    </div>
                @endif
                <div class="ps-2">
                    <label for="foto" class="absolute px-1 text-xs bg-white text-gray-700">Upload Foto</label>
                    <input type="file" name="foto" id="foto"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
            </div>
            
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="nisn" class="absolute left-3 px-1 text-xs bg-gray text-gray-500">NISN</label>
                <input type="text" name="nisn" id="nisn" value="{{ Auth::user()->siswa->nisn }}" readonly
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="jenis_kelamin" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" value="{{ $siswa->jenis_kelamin ?? '' }}"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-Laki" {{ (isset($siswa->jenis_kelamin) && $siswa->jenis_kelamin == 'Laki-Laki') ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ (isset($siswa->jenis_kelamin) && $siswa->jenis_kelamin == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="tanggal_lahir" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tanggal Lahir</label>
                <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ Auth::user()->siswa->tanggal_lahir }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="kabupaten" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kabupaten/Kota Asal</label>
                <input type="text" name="kabupaten" id="kabupaten" placeholder="Asal Kabupaten/Kota" value="{{ $siswa->kabupaten ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="kecamatan" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kecamatan Asal</label>
                <input type="text" name="kecamatan" id="kecamatan" placeholder="Asal Kecamatan" value="{{ $siswa->kecamatan ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="desa" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kelurahan/Desa Asal</label>
                <input type="text" name="desa" id="desa" placeholder="Asal Desa/Kelurahan" value="{{ $siswa->desa ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            
            <div class="sm:col-span-6 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="alamat" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Alamat Lengkap</label>
                <input type="text" name="alamat" id="alamat" placeholder="Alamat Rumah" value="{{ $siswa->alamat ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="no_kk" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor KK</label>
                <input type="text" name="no_kk" id="no_kk" placeholder="No KK" value="{{ $siswa->no_kk ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="nik" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor Induk Kependudukan</label>
                <input type="text" name="nik" id="nik" placeholder="NIK" value="{{ $siswa->nik ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="no_hp" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor Hp/Telephone</label>
                <input type="text" name="no_hp" id="no_hp" placeholder="No HP" value="{{ $siswa->no_hp ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="nama_ayah" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap Ayah</label>
                <input type="text" name="nama_ayah" id="nama_ayah" placeholder="Nama Ayah" value="{{ $siswa->nama_ayah ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="nama_ibu" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap Ibu</label>
                <input type="text" name="nama_ibu" id="nama_ibu" placeholder="Nama Ibu" value="{{ $siswa->nama_ibu ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="email" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Email Pribadi</label>
                <input type="text" name="email" id="email" placeholder="E-mail" value="{{ Auth::user()->email }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="agama" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Agama</label>
                <select name="agama" id="agama" value="{{ $siswa->agama ?? '' }}"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ (isset($siswa->agama) && $siswa->agama == 'Islam') ? 'selected' : '' }}>Islam</option>
                        <option value="Katolik" {{ (isset($siswa->agama) && $siswa->agama == 'Katolik') ? 'selected' : '' }}>Katolik</option>
                        <option value="Kristen Protestan" {{ (isset($siswa->agama) && $siswa->agama == 'Kristen Protestan') ? 'selected' : '' }}>Kristen Protestan</option>
                        <option value="Hindu" {{ (isset($siswa->agama) && $siswa->agama == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ (isset($siswa->agama) && $siswa->agama == 'Budha') ? 'selected' : '' }}>Budha</option>
                        <option value="Konghucu" {{ (isset($siswa->agama) && $siswa->agama == 'Konghucu') ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>
            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="kebutuhan_k" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kebutuhan Khusus</label>
                <input type="text" name="kebutuhan_k" id="kebutuhan_k" placeholder="(Kosongkan Jika Tidak Punya)" value="{{ $siswa->kebutuhan_k ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="sekolah_asal_id" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Sekolah Asal</label>
                <select name="sekolah_asal_id" id="sekolah_asal_id"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                    <option value="">Pilih Asal Sekolah</option>
                    @foreach ($sekolahAsals as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ (isset($siswa->sekolah_asal_id) && $siswa->sekolah_asal_id == $sekolah->id) ? 'selected' : '' }}>
                            {{ $sekolah->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="akta_file" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Akta Kelahiran</label>
                <input type="file" name="akta_file" id="akta_file" value=""
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                <div class="bg-green-500 rounded-full w-5 absolute right-3 top-5">
                    @if (isset($siswa->akta_file) && $siswa->akta_file)
                        <svg class="check-akta" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Data Wali --}}
<div class="border border-gray-400 p-6 rounded-lg mt-6">
    <div>
    Data <span class="font-bold">Orang Tua / Wali Murid</span>
    </div>

    <div class="space-y-10">
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
            
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="nama_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Orang Tua/Wali</label>
                <input type="text" name="nama_wali" id="nama_wali" placeholder="Nama Lengkap" value="{{ $siswa->ortu->nama_wali ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="tempat_lahir_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tempat Lahir Orang Tua/Wali</label>
                <input type="text" name="tempat_lahir_wali" id="tempat_lahir_wali" placeholder="Tempat Lahir" value="{{ $siswa->ortu->tempat_lahir_wali ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="tanggal_lahir_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tanggal Lahir Orang Tua/Wali</label>
                <input type="date" name="tanggal_lahir_wali" id="tanggal_lahir_wali" placeholder="Tanggal Lahir" value="{{ $siswa->ortu->tanggal_lahir_wali ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="pekerjaan_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Pekerjaan Orang Tua/Wali</label>
                <input type="text" name="pekerjaan_wali" id="pekerjaan_wali" placeholder="Pekerjaan" value="{{ $siswa->ortu->pekerjaan_wali ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-4 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="alamat_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Alamat Orang Tua/Wali</label>
                <input type="text" name="alamat_wali" id="alamat_wali" placeholder="Alamat Lengkap" value="{{ $siswa->ortu->alamat_wali ?? '' }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

        </div>
    </div>
</div>