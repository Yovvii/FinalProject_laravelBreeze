<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan Kesanggupan</title>
    <!-- Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Pustaka html2pdf.js untuk mengkonversi HTML ke PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: 'times new roman', serif;
            background-color: white;
        }
        @media print {
            #letter-content {
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                padding: 20mm; 
                box-shadow: none;
                background-color: white;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">

    <!-- Kontainer utama untuk surat -->
    <div id="letter-content" class="bg-white p-8 md:p-12 rounded-lg shadow-xl max-w-4xl w-full">

        <!-- Header Surat -->
        <h1 class="text-xl md:text-2xl font-bold text-center mb-6">SURAT PERNYATAAN</h1>
        <hr class="border-gray-300 mb-6">

        <!-- Isi Surat -->
        <div class="text-sm md:text-base leading-relaxed text-gray-800">
            <p class="mb-4">Yang bertanda tangan di bawah ini :</p>

            <div class="space-y-2 mb-6 ml-4">
                <div class="flex">
                    <div class="w-48">Nama Lengkap</div>
                    <div class="mr-2">:</div>
                    <div class="flex-1 font-normal">{{ $nama_siswa }}</div>
                </div>
                <div class="flex">
                    <div class="w-48">NISN</div>
                    <div class="mr-2">:</div>
                    <div class="flex-1 font-normal">{{ $nisn }}</div>
                </div>
                <div class="flex">
                    <div class="w-48">Tempat dan Tanggal Lahir</div>
                    <div class="mr-2">:</div>
                    <div class="flex-1 font-normal">{{ $kabupaten . ', ' . $tanggal_lahir }}</div>
                </div>
                <div class="flex">
                    <div class="w-48">Alamat</div>
                    <div class="mr-2">:</div>
                    <div class="flex-1 font-normal">{{ $alamat_siswa }}</div>
                </div>
            </div>

            <p class="mb-4">Dengan ini menyatakan bahwa saya SANGGUP :</p>

            <ol class="list-decimal list-inside space-y-2 mb-6 ml-4">
                <li>Menaati semua peraturan, tata tertib, dan kode etik yang berlaku di SMA/SMK Kabupaten Purbalingga.</li>
                <li>Menjunjung tinggi nama baik almamater, guru, dan seluruh staf pengajar.</li>
                <li>Berpartisipasi aktif dalam setiap kegiatan belajar-mengajar dan kegiatan sekolah lainnya yang diwajibkan.</li>
                <li>Menyelesaikan seluruh kewajiban, baik akademis maupun finansial, yang ditetapkan oleh pihak sekolah.</li>
            </ol>

            <p class="mb-4">Apabila di kemudian hari saya tidak dapat memenuhi salah satu dari poin pernyataan di atas, saya bersedia menerima sanksi yang diberikan oleh pihak sekolah sesuai dengan ketentuan yang berlaku, termasuk namun tidak terbatas pada skorsing atau dikeluarkan dari sekolah.</p>

            <p class="mb-8">Demikian surat pernyataan ini dibuat dengan sadar, tanpa paksaan, dan disaksikan oleh orang tua/wali.</p>

            <div class="flex justify-end">
                <p>{{ $kabupaten . ', ' . $tanggal_surat }}</p>
            </div>
            <p class="ms-20 ps-3">Mengetahui,</p>
            <div class="flex justify-between items-center text-center px-10">
                <div class="flex flex-col items-center">
                    <p>Orang Tua/Wali</p>
                    <div class="my-2 h-24 w-40 flex items-end justify-center">
                    </div>
                    <p class="mt-1">( {{ $nama_wali }} )</p>
                </div>
                <div class="flex flex-col items-center">
                    <p>Calon Peserta Didik,</p>
                    <div class="my-2 h-24 w-40 flex items-end justify-center">
                        <p class="text-sm text-gray-500">(Materai 10.000)</p>
                    </div>
                    <p class="mt-1">( {{ $nama_siswa }} )</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
