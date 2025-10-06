<div class="border border-blue-400 p-6 rounded-lg">
    <div>
    Data <span class="font-bold">Orang Tua / Wali Murid</span>
    </div>

    <div class="space-y-5">
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-8">
            
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="name" class="absolute left-3 px-1 text-xs text-gray-500">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" readonly
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="nisn" class="absolute left-3 px-1 text-xs text-gray-500">NISN</label>
                <input type="text" name="nisn" id="nisn" value="{{ Auth::user()->siswa->nisn }}" readonly
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="kabupaten" class="absolute left-3 px-1 text-xs text-gray-500">Kabupaten/Kota Asal</label>
                <input type="text" name="kabupaten" id="kabupaten" placeholder="Asal Kabupaten/Kota" value="{{ $siswa->kabupaten ?? '' }}" readonly
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="tanggal_lahir" class="absolute left-3 px-1 text-xs text-gray-500">Tanggal Lahir</label>
                <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ Auth::user()->siswa->tanggal_lahir }}" readonly
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-6 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="alamat" class="absolute left-3 px-1 text-xs text-gray-500">Alamat Lengkap</label>
                <input type="text" name="alamat" id="alamat" placeholder="Alamat Rumah" value="{{ $siswa->alamat ?? '' }}" readonly
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-2 relative px-3 pt-3 border border-gray-400 rounded-lg bg-gray-300">
                <label for="nama_wali" class="absolute left-3 px-1 text-xs text-gray-500">Nama Orang Tua/Wali</label>
                <input type="text" name="nama_wali" id="nama_wali" placeholder="Nama Lengkap" value="{{ $siswa->ortu->nama_wali ?? '' }}" readonly
                class="bg-gray-300 block w-full px-1 mt-3 text-base text-gray-500 border-0 focus:ring-0 focus:outline-none">
            </div>

        </div>
        <div class="flex items-center w-64 rounded-lg bg-gray-800 px-3 py-2 hover:bg-blue-800 ">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="white" d="M13 5v6h1.17L12 13.17L9.83 11H11V5zm2-2H9v6H5l7 7l7-7h-4zm4 15H5v2h14z"/></svg>
            <a href="{{ route('download.surat.pernyataan') }}">
                <span class="text-white ml-1">Download Surat Pernyataan</span>
            </a>
        </div>
    </div>
</div>

<div class="border bg-blue-100 p-4 rounded-lg mt-8">

    <div class="">
        <p>Upload Document</p>
        <span class="font-bold">Surat Pernyataan Kesanggupan</span>
    </div>

    <div class="space-y-5 my-7">
        <div class="sm:col-span-3 relative px-2 pt-3 border bg-white rounded-lg">
            <label for="surat_pernyataan" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Surat Pernyataan Kesanggupan</label>
            <input type="file" name="surat_pernyataan" id="surat_pernyataan" 
                @if (!isset($siswa->surat_pernyataan) || is_null($siswa->surat_pernyataan)) required @endif
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            <div class="bg-green-500 rounded-full w-5 absolute right-3 top-5">
                @if (isset($siswa->surat_pernyataan) && $siswa->surat_pernyataan)
                    <svg class="check-akta" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <div>
        <p class="text-xs text-gray-700">
            <span class="font-extrabold text-base text-black">Catatan :</span> <br>
            Pastikan file dokumen yang di upload telah ditandatangani dan bermaterai <br>
            Ekstensi file PDF berukuran maksimal 500 KB
        </p>
    </div>
</div>