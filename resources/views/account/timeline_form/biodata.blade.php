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
            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="foto" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Foto</label>
                <input type="file" name="foto" id="foto"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="nisn" class="absolute left-3 px-1 text-xs bg-gray text-gray-500">NISN</label>
                <input type="text" name="nisn" id="nisn" value="{{ Auth::user()->siswa->nisn }}"
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="jenis_kelamin" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                        <option value="laki-laki">Laki-Laki</option>
                        <option value="perempuan">Perempuan</option>
                </select>
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="tanggal_lahir" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tanggal Lahir</label>
                <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ Auth::user()->siswa->tanggal_lahir }}"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="kabupaten" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kabupaten/Kota Asal</label>
                <input type="text" name="kabupaten" id="kabupaten" placeholder="Asal Kabupaten/Kota"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="kecamatan" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kecamatan Asal</label>
                <input type="text" name="kecamatan" id="kecamatan" placeholder="Asal Kecamatan"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="desa" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kelurahan/Desa Asal</label>
                <input type="text" name="desa" id="desa" placeholder="Asal Desa/Kelurahan"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            
            <div class="sm:col-span-6 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="alamat_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Alamat Lengkap</label>
                <input type="text" name="alamat_lengkap" id="alamat_lengkap" placeholder="Alamat Rumah"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="no_kk" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor KK</label>
                <input type="text" name="no_kk" id="no_kk" placeholder="No KK"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="nik" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor Induk Kependudukan</label>
                <input type="text" name="nik" id="nik" placeholder="NIK"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="no_hp" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor Hp/Telephone</label>
                <input type="text" name="no_hp" id="no_hp" placeholder="No HP"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="nama_ayah" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap Ayah</label>
                <input type="text" name="nama_ayah" id="nama_ayah" placeholder="Nama Ayah"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="nama_ibu" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap Ibu</label>
                <input type="text" name="nama_ibu" id="nama_ibu" placeholder="Nama Ibu"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="email" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Email Pribadi</label>
                <input type="text" name="email" id="email" placeholder="E-mail"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="agama" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Agama</label>
                <input type="text" name="agama" id="agama" placeholder="Pilih Agama"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="kebutuhan_k" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kebutuhan Khusus</label>
                <input type="text" name="kebutuhan_k" id="kebutuhan_k" placeholder="Berkebutuhan Khusus"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="sekolah_asals_id" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Sekolah Asal</label>
                <input type="text" name="sekolah_asals_id" id="sekolah_asals_id" placeholder="Asal Sekolah"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="akta" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Akta Kelahiran</label>
                <input type="file" name="akta" id="akta"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
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
                <input type="text" name="nama_wali" id="nama_wali" placeholder="Nama Lengkap"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="tempat_lahir_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tempat Lahir Orang Tua/Wali</label>
                <input type="text" name="tempat_lahir_wali" id="tempat_lahir_wali" placeholder="Tempat Lahir"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="tanggal_lahir_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tanggal Lahir Orang Tua/Wali</label>
                <input type="date" name="tanggal_lahir_wali" id="tanggal_lahir_wali" placeholder="Tanggal Lahir"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="pekerjaan_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Pekerjaan Orang Tua/Wali</label>
                <input type="text" name="pekerjaan_wali" id="pekerjaan_wali" placeholder="Pekerjaan"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-4 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="alamat_wali" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Alamat Orang Tua/Wali</label>
                <input type="text" name="alamat_wali" id="alamat_wali" placeholder="Alamat Lengkap"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

        </div>
    </div>
</div>