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
                <div class="bg-green-500 rounded-full w-5 absolute right-3 top-5">
                @if (isset($siswa->surat_keterangan_lulus) && $siswa->surat_keterangan_lulus)
                    <svg class="check-akta" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
            </div>
            <div class="sm:col-span-6 relative px-3 pt-3 border border-gray-400 rounded-lg">
                <label for="ijazah_file" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Ijazah</label>
                <input type="file" name="ijazah_file" id="ijazah_file"
                class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                <div class="bg-green-500 rounded-full w-5 absolute right-3 top-5">
                @if (isset($siswa->ijazah_file) && $siswa->ijazah_file)
                    <svg class="check-akta" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
            </div>

        </div>
    </div>
</div>