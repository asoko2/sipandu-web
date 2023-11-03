@php
    // dd($data);
    $verifikator = DB::table('verifikators')
        ->where('user_id', Auth::user()->id)
        ->first();

    $no = $verifikator->no;

    if ($no == 1) {
        $verif = $data->verifikator_1;
    } elseif ($no == 2) {
        $verif = $data->verifikator_2;
    } elseif ($no == 3) {
        $verif = $data->verifikator_3;
    } elseif ($no == 4) {
        $verif = $data->verifikator_4;
    } elseif ($no == 5) {
        $verif = $data->verifikator_5;
    } else {
        $verif = $data->verifikator_6;
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Ceklis - SiPandu</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href=https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
</head>

<body>
    <div class="kop_dokumen w-100 items-center text-center">
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
            <div class="col-sm-8">{{ $data->nama_desa }}</div>
        </div>
    </div>
    <br />
    <div class="col-sm-12">
        <p>
            <b>1. Check List Kelengkapan Dokumentasi Pengajuan : </b>
        </p>
    </div>
    <table class="w-100" border="1" id="ceklist_dokumen">
        <col style="width:5%;">
        <col style="width:50%;">
        <colgroup span="3"></colgroup>
        <thead style="text-transform: uppercase" class="text-center">
            <tr>
                <th rowspan="3">NO</th>
                <th rowspan="3">URAIAN</th>
                <th colspan="3" scope="colgroup" style="text-align: center;">HASIL PEMERIKSAAN</th>
            </tr>
            <tr>
                <th scope="colgroup" colspan="2" style="text-align: center">ADA</th>
                <th rowspan="2" scope="colgroup" style="vertical-align: center; width: 5%">TIDAK ADA</th>
            </tr>
            <tr>
                <th scope="colgroup" style="width: 6%;">SESUAI <br />KETENTUAN</th>
                <th scope="colgroup" style="width: 5%">TIDAK SESUAI<br /> KETENTUAN</th>
            </tr>
        </thead>
        <tbody>
            <tr class="checklist">
                <td style="text-align: center;"><b>1.</b></td>
                <td>
                    <label for="suratPermintaanPembayaranSPP" class="col-form-label">Surat Permintaan
                        Pembayaran SPP</label>
                </td>
                <td>
                    @if ($data->check_surat_permintaan_pembayaran_spp == 1)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_surat_permintaan_pembayaran_spp == 2)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_surat_permintaan_pembayaran_spp == 3)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    <b>2.</b>
                </td>
                <td>
                    <label for="rab" class="col-form-label">Rencana Anggaran Biaya</label>
                </td>
                <td>
                    @if ($data->check_rab == 1)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_rab == 2)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_rab == 3)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    <b>3. </b>
                </td>
                <td>
                    <label for="pernyataanPertanggungJawaban" class="col-form-label">Pernyataan
                        Pertanggung
                        Jawaban</label>
                </td>
                <td>
                    @if ($data->check_pernyataan_pertanggungjawaban == 1)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_pernyataan_pertanggungjawaban == 2)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_pernyataan_pertanggungjawaban == 3)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    <b>4. </b>
                </td>
                <td>
                    <label for="dpa" class="col-form-label">Belanja DPA</label>
                </td>
                <td>
                    @if ($data->check_belanja_dpa == 1)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_belanja_dpa == 2)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_belanja_dpa == 3)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    <b>5. </b>
                </td>
                <td>
                    <label for="skTimPelaksana" class="col-form-label">SK Tim Pelaksana</label>
                </td>
                <td>
                    @if ($data->check_sk_tim_pelaksana == 1)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_tim_pelaksana == 2)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_tim_pelaksana == 3)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
            </tr>
            <tr class="checklist">
                <td style="text-align: center;">
                    <b>6.</b>
                </td>
                <td>
                    <label for="skDasarKegiatan" class="col-form-label">SK Dasar Kegiatan</label>
                </td>
                <td>
                    @if ($data->check_sk_dasar_kegiatan == 1)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_dasar_kegiatan == 2)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_sk_dasar_kegiatan == 3)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
            </tr>

            <tr>
                <td>
                    <label for="catatan" class="col-form-label">Catatan</label>
                </td>
                <td colspan="4">
                    <textarea class="form-control" name="catatan">{{ old('catatan', $data->catatan) }}</textarea>
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
    <table id="checklis_persyaratan" border="1" class="w-100">
        <col style="width: 5%;">
        <col style="width: 51%;">
        <colgroup span="2"></colgroup>
        <thead style="text-align: center;">
            <tr>
                <th rowspan="2">NO.</th>
                <th rowspan="2">URAIAN</th>
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
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_lapor_pertanggungjawaban == 2)
                        <i class="fas fa-check"></i>
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
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td>
                    @if ($data->check_patuh_kebijakan == 2)
                        <i class="fas fa-check"></i>
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
    <div class="rekomendasi col-sm-6">
        <div class="row">
            <div class="col-sm-6">Rekomendasi ini dibuat di</div>
            <div class="col-sm-1">:</div>
            <div>Kecamatan Kasiman</div>
        </div>
        <div class="row">
            <div class="col-sm-6">Tanggal</div>
            <div class="col-sm-1">:</div>
            <div>
                {{ date('d M Y') }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">Dibuat oleh Petugas verifikasi</div>
            <div class="col-sm-1">:</div>
        </div>
    </div>
    <table id="verifikator" border="1" class="w-100">
      <thead style="text-align: center;">
        <tr>
          <th style="padding-top: 16px; padding-bottom: 16px;">NAMA</th>
          <th>TANDA TANGAN</th>
        </tr>
      </thead>
      <tbody>
        @php
            $verifikator = DB::table('verifikators as v')
                              ->select('v.*', 'u.name')
                              ->join('users as u', 'v.user_id','=','u.id')
                              ->get();
        @endphp
        @foreach ($verifikator as $v)
            <tr>
              <td  style="padding-top: 12px; padding-bottom: 12px; padding-left: 24px;">
                {{ $v->no }}. {{ $v->name }}
              </td>
              <td style="padding-left: 24px;">{{ $v->no }}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
    <br/>
    <b>*) Coret yang tidak sesuai</b>
</body>

</html>
