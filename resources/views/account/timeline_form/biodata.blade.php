{{-- Data Siswa --}}
<div class="border border-gray-400 p-6 rounded-lg">
    <div>
        Data <span class="font-bold">Calon Murid Baru</span>
    </div>

    <form method="POST" action="">
        @csrf
        @method('PATCH')

        <div class="space-y-10">
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
                
                <div class="sm:col-span-3">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Nama Lengkap</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name" value="{{ Auth::user()->name }}"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Upload Foto</label>
                    <div class="mt-2 border border-gray-500 block w-full rounded-md py-1">
                        <input id="password_confirmation" type="file" name="password_confirmation" autocomplete="family-name" 
                        class="rounded-md w-full bg-white px-3 text-xs text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">NISN</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name" value="{{ Auth::user()->siswa->nisn }}"
                        class="block w-full rounded-md bg-gray-300 px-3 py-1.5 text-base text-gray-500 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Jenis Kelamin</label>
                    <div class="mt-2">
                        <select name="jenis_kelamin" id="jenis_kelamin"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Tanggal Lahir</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name" value="{{ Auth::user()->siswa->tanggal_lahir }}"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Kabupaten</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Kecamatan Asal</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Kelurahan/Desa Asal</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                
                <div class="sm:col-span-6">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Alamat Lengkap</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Nomor KK</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">NIK</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Nomor HP</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Nama Lengkap Ayah</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Nama Lengkap Ibu</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Email Pribadi</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Agama</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Kebutuhan Khusus</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Sekolah Asal</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Akta Kelahiran</label>
                    <div class="mt-2 border border-gray-500 block w-full rounded-md py-1">
                        <input id="password_confirmation" type="file" name="password_confirmation" autocomplete="family-name" 
                        class="rounded-md w-full bg-white px-3 text-xs text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                    </div>
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
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
                
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Nama Orang Tua/Wali</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Tempat Lahir Orang Tua/Wali</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Tanggal Lahir Orang Tua/Wali</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Pekerjaan Orang Tua/Wali</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>
                <div class="sm:col-span-4">
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Alamat Orang Tua/Wali</label>
                    <div class="mt-2">
                        <input id="nama" type="text" name="nama" autocomplete="family-name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />                         
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>