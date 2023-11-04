
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Ceklis - SiPandu</title>


    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet"
        href=https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
    <style>
        * {
            font-family: serif;
        }

        #ceklist_dokumen tbody td:nth-child(-n+5):nth-child(n+3) {
            text-align: center;
        }

        #ceklist_dokumen tbody td:nth-child(2) {
            padding-left: 12px;
        }

        #ceklist_persyaratan tbody td:nth-child(-n+4):nth-child(n+3) {
            text-align: center;
        }

        #ceklist_persyaratan tbody td:nth-child(2) {
            padding-left: 12px;
        }

        #verifikator_table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        #verifikator_table th {
            border: 1px solid black;
        }

        #verifikator_table td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="kop_dokumen w-100 items-center text-center font-weight-bold">
        <p>
            REKOMENDASI DAN VERIFIKASI PERSYARATAN<br />
            PENGAJUAN PENCAIRAN ADD, DD, BHPD DAN BHRD
        </p>
    </div>
    <div class="nama_desa col-sm-3">
        <div class="row">
            <div class="col-sm-3">Kabupaten</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-8">Bojonegoro</div>
        </div>
        <div class="row">
            <div class="col-sm-3">Kecamatan</div>
            <div class="col-sm-1">:</div>
            <div class="col-sm-8">Kasiman</div>
        </div>
        <div class="row">
            <div class="col-sm-3">Desa</div>
            <div class="col-sm-1">:</div>
        </div>
    </div>
    {{-- <br />
    <div class="col-sm-12">
        <p>
            <b>1. Check List Kelengkapan Dokumentasi Pengajuan : </b>
        </p>
    </div>
    <br />
    <div class="col-sm-12">
        <p>
            <b>2. Check List Persyaratan Lainnya</b>
        </p>
    </div>
    <br />
    <p>
        Berdasarkan hasil pemeriksaan kelengkapan dokumen dan persyaratan lainnya, serta hasil pembahasan bersama antara
        Tim Pendamping maka dapat direkomendasikan sebagai berikut:
    </p>
    <p>
        <b>A. LAYAK</b> atau <b>MEMENUHI SYARAT</b> dan bisa digunakan untuk mengajukan permohonan penyaluran
    </p>
    <p>
        <b>B. TIDAK LAYAK</b> dan perlu di perbaiki /dicukupi kembali oleh Desa *)
    </p>
    <p>Catatan :</p>
    <div class="w-100" style="border: 1px solid black; padding: 8px;">
        CATATAN
    </div> --}}
    <br />
    {{-- <div class="rekomendasi col-sm-6">
        <div class="row">
            <div class="col-sm-6">Rekomendasi ini dibuat di</div>
            <div class="col-sm-1">:</div>
            <div>Kecamatan Kasiman</div>
        </div>
        <div class="row">
            <div class="col-sm-6">Tanggal</div>
            <div class="col-sm-1">:</div>
            <div>
                {{-- {{ date('d M Y') }} --}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">Dibuat oleh Petugas verifikasi</div>
            <div class="col-sm-1">:</div>
        </div>
    </div> --}}
    <br />
    <b>*) Coret yang tidak sesuai</b>
</body>

</html>
