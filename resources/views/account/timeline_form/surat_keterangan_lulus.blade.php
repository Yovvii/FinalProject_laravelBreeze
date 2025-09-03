{{-- Data Siswa --}}
<div class="border border-gray-400 p-6 rounded-lg">
    <div>
    Data <span class="font-bold">Surat Keterangan Lulus dan Ijazah</span>
    </div>

    <div class="space-y-10 mt-5">
        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
            
            <div class="sm:col-span-6 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="surat_keterangan_lulus" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Dokumen Surat Keterangan Lulus</label>
                <input type="file" name="surat_keterangan_lulus" id="surat_keterangan_lulus"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>
            <div class="sm:col-span-6 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="ijazah_file" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Ijazah</label>
                <input type="file" name="ijazah_file" id="ijazah_file"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
            </div>

        </div>
    </div>
</div>