<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
    <div class="border border-gray-400 p-6 rounded-lg gap-5 items-start">
        <p class="font-semibold text-lg pb-4 mb-4 border-b border-gray-800 w-full">Resume Pendaftaran SMA Jalur Prestasi</p>

        <p class="font-semibold text-base mb-1">Data Calon Murid</p>
        <div class="grid grid-cols-6 border border-gray-300 mb-4">
            <ul class="col-span-2 border-e border-gray-300">
                <li class="ps-3 py-2 border-b border-gray-300">Nama Lengkap</li>
                <li class="ps-3 py-2 border-b border-gray-300">NISN</li>
                <li class="ps-3 py-2 border-b border-gray-300">Alamat </li>
                <li class="ps-3 py-2 border-b border-gray-300">Tanggal Lahir</li>
                <li class="ps-3 py-2 border-b border-gray-300">Sekolah Asal</li>
                <li class="ps-3 py-2">No HP</li>
            </ul>
            <ul class="col-span-4">
                <li class="ps-3 py-2 border-b border-gray-300">{{ Auth::user()->name }}</li>
                <li class="ps-3 py-2 border-b border-gray-300">{{ $siswa->nisn }}</li>
                <li class="ps-3 py-2 border-b border-gray-300">{{ $siswa->alamat }}</li>
                <li class="ps-3 py-2 border-b border-gray-300">{{ $siswa->tanggal_lahir }}</li>
                <li class="ps-3 py-2 border-b border-gray-300">{{ $siswa->sekolahAsal->nama_sekolah ?? '-' }}</li>
                <li class="ps-3 py-2">{{ $siswa->no_hp }}</li>
            </ul>
        </div>
        
        <p class="font-semibold text-base mb-1">Data Pendaftaran</p>
        <div class="grid grid-cols-6 border border-gray-300">
            <ul class="col-span-2 border-e border-gray-300">
                <li class="ps-3 py-2 border-b border-gray-300">Jalur Pendaftaran</li>
                <li class="ps-3 py-2">Sekolah Tujuan</li>
            </ul>
            <ul class="col-span-4">
                <li class="ps-3 py-2 border-b border-gray-300">{{ $siswa->jalurPendaftaran->nama_jalur_pendaftaran ?? '-' }}</li>
                <li class="ps-3 py-2">{{ $siswa->dataSma->nama_sma ?? '-' }}</li>
            </ul>
        </div>
        
        <input type="hidden" name="nilai_akhir" value="{{ number_format($nilaiAkhir, 2) }}">
        <p class="font-semibold text-base mb-1 mt-4">Data Nilai Rapor</p>
        <div class="grid grid-cols-7 grid-rows-7 border border-gray-300 content-center">
            <p class="row-span-2 col-span-2 ps-3 py-2 border-e border-gray-300 content-center text-center">Mata Pelajaran</p>
            <p class="row-span-1 col-span-5 ps-3 py-2 border-b border-gray-300 text-center">Nilai Rapor</p>
            <p class="row-span-1 col-span-1 ps-3 py-2 border-e border-gray-300 text-center">Semester 1</p>
            <p class="row-span-1 col-span-1 ps-3 py-2 border-e border-gray-300 text-center">Semester 2</p>
            <p class="row-span-1 col-span-1 ps-3 py-2 border-e border-gray-300 text-center">Semester 3</p>
            <p class="row-span-1 col-span-1 ps-3 py-2 border-e border-gray-300 text-center">Semester 4</p>
            <p class="row-span-1 col-span-1 ps-3 py-2 border-gray-300 text-center">Semester 5</p>

            @php
                $uniqueMapels = $siswa->semesters->pluck('mapels')->unique('id');
            @endphp

            @foreach ($uniqueMapels as $mapel)
                <p class="row-span-1 col-span-2 border-e border-t border-gray-300 ps-3 content-center">{{ $mapel->nama_mapel ?? 'N/A' }}</p>
                @for ($i = 1; $i <= 5; $i++)
                    @php
                        $nilai = $siswa->semesters->where('mapel_id', $mapel->id)->where('semester', $i)->first();
                    @endphp
                    <p class="row-span-1 col-span-1 border-e border-t border-gray-300 ps-3 text-center content-center">
                        {{ $nilai->nilai_semester ?? '-' }}
                    </p>
                @endfor
            @endforeach

            <p class="row-span-1 col-span-2 border-e border-t border-gray-300 ps-3 font-bold content-center">Nilai Akhir</p>
            <p class="row-span-1 col-span-5 border-e border-t border-gray-300 ps-3 font-bold content-center text-center">{{ number_format($nilaiAkhir, 2) }}</p>
        </div>
    </div>
</div>