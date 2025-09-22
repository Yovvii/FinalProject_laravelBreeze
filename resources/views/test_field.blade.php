 <x-app-layout>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="border bg-blue-100 p-4 rounded-lg">
                    <div class="">
                        <p>Upload Document</p>
                        <span class="font-bold">Sertifikat/Piagam Penghargaan</span>
                    </div>

                    <div class="space-y-5 my-7">
                        <div class="sm:col-span-3 relative px-2 pt-3 border bg-white rounded-lg">
                            <label for="surat_pernyataan" class="absolute left-3 px-1 text-xs bg-white text-gray-700">Upload Sertifikat/Piagam Penghargaan Jika Ada</label>
                            <input type="file" name="surat_pernyataan" id="surat_pernyataan"
                            class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                            {{-- <div class="bg-green-500 rounded-full w-5 absolute right-3 top-5">
                                @if (isset($siswa->surat_pernyataan) && $siswa->surat_pernyataan)
                                    <svg class="check-akta" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div> --}}
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-700">
                            <span class="font-extrabold text-base text-black">Catatan :</span> <br>
                            Pastikan sertifikat/piagam yang di upload asli tanpa rekayasa apapun<br>
                            Ekstensi file PDF berukuran maksimal 500 KB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>