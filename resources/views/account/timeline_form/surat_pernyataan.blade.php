<div class="border border-blue-400 p-6 rounded-lg">
    <div>
    Data <span class="font-bold">Orang Tua / Wali Murid</span>
    </div>

    <form method="POST" action="">
        @csrf
        @method('PATCH')

        <div class="space-y-5">
            <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
                
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Nama Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap (sudah di input)"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tempat Lahir Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Tempat Lahir (sudah di input)"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Tanggal Lahir Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Tanggal Lahir (sudah di input)"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

                <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Pekerjaan Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Pekerjaan (sudah di input)"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
                <div class="sm:col-span-4 relative px-3 pt-3 border border-gray-400 rounded-lg">
                    <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Alamat Orang Tua/Wali</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Alamat Lengkap (sudah di input)"
                    class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>

            </div>
            <div class="flex items-center w-64 rounded-lg bg-gray-800 px-3 py-2 hover:bg-blue-800 ">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="white" d="M13 5v6h1.17L12 13.17L9.83 11H11V5zm2-2H9v6H5l7 7l7-7h-4zm4 15H5v2h14z"/></svg>
                <a href="">
                    <span class="text-white ml-1">Download Surat Pernyataan</span>
                </a>
            </div>
        </div>
    </form>
</div>

<div class="border bg-blue-100 p-4 rounded-lg mt-8">

    <div class="">
        <p>Upload Document</p>
        <span class="font-bold">Surat Pernyataan Bebas Narkoba</span>
    </div>

    <form method="POST" action="">
        @csrf
        @method('PATCH')

        <div class="space-y-5 my-7">
           <div class="sm:col-span-3 relative px-2 pt-3 border bg-white rounded-lg">
                <label for="nama_lengkap" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Surat Pernyataan Bebas Narkoba</label>
                <input type="file" name="nama_lengkap" id="nama_lengkap"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
        </div>
    </form>

    <div>
        <p class="text-xs text-gray-700">
            <span class="font-extrabold text-base text-black">Catatan :</span> <br>
            Pastikan file dokumen yang di upload telah ditandatangani dan bermaterai <br>
            Ekstensi file PDF berukuran maksimal 500 KB
        </p>
    </div>
</div>