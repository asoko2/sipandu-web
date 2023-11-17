<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Ceklis - SiPandu</title>


    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet"
        href=https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
    <style>
        * {
            font-family: serif;
        }

        .checklist {
            font-family: "DejaVu Sans Mono", monospace;
        }

        #ceklist_dokumen tbody td:nth-child(-n+5):nth-child(n+3) {
            text-align: center;
        }

        #ceklist_dokumen tbody td:nth-child(2) {
            padding-left: 12px;
        }

        #ceklist_dokumen th {
            padding: 8px;
        }

        #ceklist_persyaratan {
            width: 100%;
            border-collapse: collapse;
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
            width: 100%:
        }

        #verifikator_table th {
            border: 1px solid black;
        }

        #verifikator_table td {
            border: 1px solid black;
        }

        .kop_dokumen {
            width: 100%;
            font-weight: bold;
            text-align: center;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        #table_lokasi td {
            padding-left: 4px;
            padding-right: 4px;
        }
    </style>
</head>

<body>
    <div class="kop_dokumen w-100 items-center">
        <p>
            REKOMENDASI DAN VERIFIKASI PERSYARATAN<br />
            PENGAJUAN PENCAIRAN ADD, DD, BHPD DAN BHRD
        </p>
    </div>
    <table id="table_lokasi">
        <tbody>
            <tr>
                <td>Kabupaten</td>
                <td>:</td>
                <td>Bojonegoro</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td>:</td>
                <td>Kasiman</td>
            </tr>
            <tr>
                <td>Desa</td>
                <td>:</td>
                <td>{{ $data->nama_desa }}</td>
            </tr>
            <tr>
                <td>Kode Pengajuan</td>
                <td>:</td>
                <td>{{ $data->kode_pengajuan }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <div class="col-sm-12">
        <p>
            <b>1. Check List Kelengkapan Dokumentasi Pengajuan : </b>
        </p>
    </div>
    <table border="1" id="ceklist_dokumen" style="width: 100%; border-collapse: collapse;">
        <col style="width:3%;">
        <col style="width:50%;">
        <colgroup span="3"></colgroup>
        <thead style="text-transform: uppercase" class="text-center">
            <tr>
                <th rowspan="3" style="width: 3%;">NO</th>
                <th rowspan="3" style="width: 50%;">URAIAN</th>
                <th colspan="3" scope="colgroup" style="text-align: center;">HASIL PEMERIKSAAN (V)</th>
            </tr>
            <tr>
                <th scope="colgroup" colspan="2" style="text-align: center">ADA</th>
                <th rowspan="2" scope="colgroup" style="vertical-align: center; width: 5%">TIDAK ADA</th>
            </tr>
            <tr>
                <th scope="colgroup" style="width: 6%;">SESUAI <br />KETENTUAN</th>
                <th scope="colgroup" style="width: 5%">TIDAK <br />SESUAI</th>
            </tr>
        </thead>
        <tbody>
            <tr class="checklist">
                <td style="text-align: center;">1.</td>
                <td>
                    <label for="suratPermintaanPembayaranSPP" class="col-form-label">Surat Permintaan
                        Pembayaran SPP</label>
                </td>
                <td>
                    @if ($data->check_surat_permintaan_pembayaran_spp == 1)
                        {{-- <span class="checklist">&check;</span> --}}
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_surat_permintaan_pembayaran_spp == 2)
                        {{-- <span class="checklist">&check;</span> --}}
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_surat_permintaan_pembayaran_spp == 3)
                        {{-- <span class="checklist">&check;</span> --}}
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    2.
                </td>
                <td>
                    <label for="rab" class="col-form-label">Rencana Anggaran Biaya</label>
                </td>
                <td>
                    @if ($data->check_rab == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_rab == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_rab == 3)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    3.
                </td>
                <td>
                    <label for="pernyataanPertanggungJawaban" class="col-form-label">Pernyataan
                        Pertanggung
                        Jawaban</label>
                </td>
                <td>
                    @if ($data->check_pernyataan_pertanggungjawaban == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_pernyataan_pertanggungjawaban == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_pernyataan_pertanggungjawaban == 3)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    4.
                </td>
                <td>
                    <label for="dpa" class="col-form-label">Belanja DPA</label>
                </td>
                <td>
                    @if ($data->check_belanja_dpa == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_belanja_dpa == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_belanja_dpa == 3)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    5.
                </td>
                <td>
                    <label for="skTimPelaksana" class="col-form-label">SK Tim Pelaksana</label>
                </td>
                <td>
                    @if ($data->check_sk_tim_pelaksana == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_tim_pelaksana == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_tim_pelaksana == 3)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    6.
                </td>
                <td>
                    <label for="skDasarKegiatan" class="col-form-label">SK Dasar Kegiatan</label>
                </td>
                <td>
                    @if ($data->check_sk_dasar_kegiatan == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_dasar_kegiatan == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_dasar_kegiatan == 3)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    7.
                </td>
                <td>
                    <label for="skDasarKegiatan" class="col-form-label">SPJ</label>
                </td>
                <td>
                    @if ($data->check_spj == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_spj == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_spj == 3)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <div class="col-sm-12">
        <p>
            <b>2. Check List Persyaratan Lainnya</b>
        </p>
    </div>
    <table id="ceklist_persyaratan" border="1">
        <col style="width: 3%;">
        <col style="width: 51%;">
        <colgroup span="2" style="width: 46%;"></colgroup>
        <thead style="text-align: center;">
            <tr>
                <th rowspan="2" style="width: 3%;">NO.</th>
                <th rowspan="2" style="width: 51%">URAIAN</th>
                <th colspan="2">Hasil Pemeriksaan</th>
            </tr>
            <tr>
                <th style="width: 6%">YA</th>
                <th style="width: 6%">TIDAK</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">
                    1
                </td>
                <td>
                    <label for="check_lapor_pertanggungjawaban" class="col-form-label">
                        Semua pekerjaan/kegiatan sebelumnya telah dilaksanakan dilaporkan
                        dipertanggungjawabkan sesuai Peraturan Perundang-undangan.
                    </label>
                </td>
                <td>
                    @if ($data->check_lapor_pertanggungjawaban == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_lapor_pertanggungjawaban == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    2
                </td>
                <td>
                    <label for="check_patuh_kebijakan" class="col-form-label">
                        Mematuhi kebijakan-kebijakan Pemerintah Kabupaten, Pemerintah Provinsi,
                        Pemerintah Pusat, dan/atau amar putusan Pengadilan Tata Usaha Negara.
                    </label>
                </td>
                <td>
                    @if ($data->check_patuh_kebijakan == 1)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
                <td>
                    @if ($data->check_patuh_kebijakan == 2)
                        <span class="checklist">&check;</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
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
        {{ $data->catatan }}
    </div>
    <br />
    <table id="rekomendasi" style="width: 100%;">
        <tbody>
            <tr>
                <td>Rekomendasi ini dibuat di</td>
                <td>:</td>
                <td>Kecamatan Kasiman</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>
                    {{ date('d M Y') }}
                </td>
            </tr>
            <tr>
                <td>Dibuat oleh Petugas verifikasi</td>
                <td>:</td>
            </tr>
        </tbody>
    </table>
    <br />
    <table id="verifikator_table" style="width: 100%;">
        <thead style="text-align: center;">
            <tr>
                <th style="padding-top: 16px; padding-bottom: 16px; width: 45%">NAMA</th>
                <th colspan="2" style="width: 55%">TANDA TANGAN</th>
            </tr>
        </thead>
        <tbody>
            @php
                $verifikator = DB::table('verifikators as v')
                    ->select('v.*', 'u.name')
                    ->join('users as u', 'v.user_id', '=', 'u.id')
                    ->get();
            @endphp
            @foreach ($verifikator as $v)
                <tr>
                    <td style="padding-top: 12px; padding-bottom: 12px; padding-left: 24px;">
                        {{ $v->no }}. {{ $v->name }}
                    </td>
                    @if ($v->no % 2 == 0)
                        <td></td>
                        <td style="padding-left: 24px;">{{ $v->no }}</td>
                    @else
                        <td style="padding-left: 24px;">{{ $v->no }}</td>
                        <td></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <br />
    <b>*) Coret yang tidak sesuai</b>
</body>

</html>
