<div class="border bg-orange-100 px-6 py-4 rounded-lg">
    <p class="text-gray-500">
        Isi nilai rapor semester 1 sampai 5. Pastikan semua kolom terisi dengan benar. Unggah juga file rapor per-semester dalam format PDF, ukuran maksimal 500 KB.
    </p>
</div>

@for ($semester = 1; $semester <= 5; $semester++)
    <div class="border bg-blue-100 p-6 rounded-lg mt-4">
        <div>
            <p class="font-bold mb-2">Data Nilai Rapor Semester {{ $semester }}</p>
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-6">
                @foreach ($mapels as $mapel)
                    @php
                        $nilaiUntukMapelIni = $semesters->firstWhere(function ($item) use ($semester, $mapel) {
                            return $item->semester == $semester && $item->mapel_id == $mapel->id;
                        })->nilai_semester ?? null;
                    @endphp
                    <div class="sm:col-span-6 xl:col-span-1 relative px-3 pt-3 bg-white rounded-lg">
                        <label for="nilai_{{ $semester }}_{{ Str::snake($mapel->nama_mapel) }}" class="absolute left-3 px-1 text-xs bg-white text-gray-700">{{ $mapel->nama_mapel }}</label>
                        <input type="number" name="nilai[{{ $semester }}][{{ Str::snake($mapel->nama_mapel) }}]" id="nilai_{{ $semester }}_{{ Str::snake($mapel->nama_mapel) }}"
                               value="{{ old('nilai.' . $semester . '.' . Str::snake($mapel->nama_mapel), $nilaiUntukMapelIni) }}"
                               class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                    </div>
                @endforeach
                <div class="sm:col-span-6 xl:col-span-2 relative px-3 pt-3 bg-white rounded-lg">
                    <label for="rapor_file_{{ $semester }}" class="absolute left-3 px-1 text-xs bg-white text-gray-700 font-bold">Upload Scan Rapor Semester {{ $semester }} (PDF)</label>
                    <input type="file" name="rapor_file[{{ $semester }}]" id="rapor_file_{{ $semester }}"
                           class="block w-full px-1 mt-3 text-base text-gray-800 border-0 focus:ring-0 focus:outline-none">
                </div>
            </div>
        </div>
    </div>
@endfor
