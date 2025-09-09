<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan Kesanggupan</title>
    <!-- CSS yang dioptimalkan untuk PDF -->
    <style>
        /* Menggunakan font serif agar terlihat seperti dokumen resmi */
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
        }

        /* Mengatur ukuran kertas dan margin */
        .page {
            width: full;
            min-height: full;
            margin: auto;
            padding: -20mm;
        }

        /* Gaya untuk header dan judul */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .divider {
            border-top: 2px solid black;
            margin-bottom: 2rem;
        }
        
        /* Gaya untuk isi surat */
        .content {
            font-size: 1rem;
            line-height: 1.6;
        }

        .info-table {
            margin-bottom: 1.5rem;
            margin-left: 2rem;
        }

        .info-table td {
            padding-bottom: 0.25rem;
            vertical-align: top;
        }

        .list-container {
            margin-bottom: 1.5rem;
            margin-left: 2rem;
        }

        .signatures {
            width: 100%;
            display: table;
            table-layout: fixed;
            /* margin-top: 3rem; */
        }
        
        .signatures .cell {
            display: table-cell;
            text-align: center;
            vertical-align: top;
            width: 50%;
        }

        .signature-name {
            /* margin-top: 1rem; */
            font-weight: bold;
        }

        .signature-line {
            /* height: 96px; */
            margin: 0 auto;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .materai {
            font-size: 0.875rem;
            color: #4b5563;
        }

    </style>
</head>
<body>
    <div class="page">
        <!-- Header Surat -->
        <div class="header">
            <h1 class="title">SURAT PERNYATAAN</h1>
            <hr class="divider">
        </div>

        <!-- Isi Surat -->
        <div class="content">
            <p style="margin-bottom: 1rem;">Yang bertanda tangan di bawah ini:</p>

            <table class="info-table">
                <tbody>
                    <tr>
                        <td style="width: 200px;">Nama Lengkap</td>
                        <td>:</td>
                        <td>{{ $nama_siswa }}</td>
                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>:</td>
                        <td>{{ $nisn }}</td>
                    </tr>
                    <tr>
                        <td>Tempat dan Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ $kabupaten . ', ' . $tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $alamat_siswa }}</td>
                    </tr>
                </tbody>
            </table>

            <p style="margin-bottom: 1rem;">Dengan ini menyatakan bahwa saya SANGGUP:</p>

            <ol class="list-container" style="list-style-type: decimal; padding-left: 1.5rem;">
                <li>Menaati semua peraturan, tata tertib, dan kode etik yang berlaku di SMA/SMK Kabupaten Purbalingga.</li>
                <li>Menjunjung tinggi nama baik almamater, guru, dan seluruh staf pengajar.</li>
                <li>Berpartisipasi aktif dalam setiap kegiatan belajar-mengajar dan kegiatan sekolah lainnya yang diwajibkan.</li>
                <li>Menyelesaikan seluruh kewajiban, baik akademis maupun finansial, yang ditetapkan oleh pihak sekolah.</li>
            </ol>

            <p style="margin-bottom: 1rem;">Apabila di kemudian hari saya tidak dapat memenuhi salah satu dari poin pernyataan di atas, saya bersedia menerima sanksi yang diberikan oleh pihak sekolah sesuai dengan ketentuan yang berlaku, termasuk namun tidak terbatas pada skorsing atau dikeluarkan dari sekolah.</p>

            <p style="margin-bottom: 2rem;">Demikian surat pernyataan ini dibuat dengan sadar, tanpa paksaan, dan disaksikan oleh orang tua/wali.</p>

            <div style="text-align: right; margin-bottom: 3rem;">
                <p>{{ $kabupaten . ', ' . $tanggal_surat }}</p>
            </div>
            <p style="text-align: left; margin-left: 19%; margin-top: -10%; margin-bottom: -2%;">Mengetahui,</p>
            
            <div class="signatures">
                <div class="cell">
                    <p>Orang Tua/Wali</p>
                    <div class="signature-line" style="height: 70px"></div>
                    <p class="signature-name">( {{ $nama_wali }} )</p>
                </div>
                <div class="cell">
                    <p>Calon Peserta Didik,</p>
                    <div class="signature-line" style="height: 50px;">
                        <p class="materai">(Materai 10.000)</p>
                    </div>
                    <p class="signature-name">( {{ $nama_siswa }} )</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
