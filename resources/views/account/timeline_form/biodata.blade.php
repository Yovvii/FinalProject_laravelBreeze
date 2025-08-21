{{-- Data Siswa --}}
<div class="border border-gray-400 p-6 rounded-lg">
    <div>
        Data <span class="font-bold">Calon Murid Baru</span>
    </div>

    <form method="POST" action="">
        @csrf
        @method('PATCH')

        <div class="space-y-10">
            <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
                
                <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ Auth::user()->name }}"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Foto</label>
                    <input type="file" name="nama_lengkap" id="nama_lengkap"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

                
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-gray text-gray-500">NISN</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ Auth::user()->siswa->nisn }}"
                    class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tanggal Lahir</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ Auth::user()->siswa->tanggal_lahir }}"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                

                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kabupaten/Kota Asal</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Asal Kabupaten/Kota"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kecamatan Asal</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Asal Kecamatan"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kelurahan/Desa Asal</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Asal Desa/Kelurahan"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                
                <div class="sm:col-span-6 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Alamat Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Alamat Rumah"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor KK</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="No KK"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor Induk Kependudukan</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="NIK"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nomor Hp/Telephone</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="No HP"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap Ayah</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Ayah"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Lengkap Ibu</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Ibu"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Email Pribadi</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="E-mail"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

                <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Agama</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Pilih Agama"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Kebutuhan Khusus</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Berkebutuhan Khusus"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

                <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Sekolah Asal</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Asal Sekolah"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-3 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Akta Kelahiran</label>
                    <input type="file" name="nama_lengkap" id="nama_lengkap"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

            </div>
        </div>
        
    </form>
</div>

{{-- Data Wali --}}
<div class="border border-gray-400 p-6 rounded-lg mt-6">
    <div>
    Data <span class="font-bold">Orang Tua / Wali Murid</span>
    </div>

    <form method="POST" action="">
        @csrf
        @method('PATCH')

        <div class="space-y-10">
            <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
                
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tempat Lahir Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Tempat Lahir"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tanggal Lahir Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Tanggal Lahir"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Pekerjaan Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Pekerjaan"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-4 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Alamat Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Alamat Lengkap"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

            </div>
        </div>
    </form>
</div>