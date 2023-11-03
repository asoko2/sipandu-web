@extends('layout.app')
@section('title', 'Pengajuan Anggaran')
@push('style')
    <style>
        th,
        td {
            padding-top: 4px;
            padding-bottom: 4px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .checklist td:nth-child(-n+5):nth-child(n+3) {
            text-align: center;
        }
    </style>
@endpush
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Setuju Pengajuan Anggaran</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/operator/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/operator/pengajuan') }}">Pengajuan Anggaran</a></li>
            <li class="breadcrumb-item active">Setuju Pengajuan Anggaran</li>
        </ol>
    </div><!-- /.col -->
@endsection
@section('content')
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
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('message'))
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form class="form-horizontal" action="{{ route('verifikasi-ajuan', $data->id) }}" method="POST"">
                    @csrf
                    <div class="card-body">
                        <table class="w-6" border="1">
                            <col>
                            <col>
                            <colgroup span="3"></colgroup>
                            <thead style="text-transform: uppercase">
                                <tr>
                                    <th>DESA</th>
                                    <th>{{ $data->nama_desa }}</th>
                                    <th colspan="3" scope="colgroup" style="text-align: center;">HASIL PEMERIKSAAN</th>
                                </tr>
                                <tr>
                                    <th>TOTAL ANGGARAN</th>
                                    <th style="text-align: right;">{{ number_format($data->total_anggaran, 2, ',', '.') }}
                                    </th>
                                    <th scope="colgroup" colspan="2" style="text-align: center">ADA</th>
                                    <th rowspan="2" scope="colgroup" style="vertical-align: center">TIDAK ADA</th>
                                </tr>
                                <tr>
                                    <th>TOTAL REALISASI</th>
                                    <th style="text-align: right;">{{ number_format($realisasi, 2, ',', '.') }}</th>
                                    <th scope="colgroup">SESUAI <br />KETENTUAN</th>
                                    <th scope="colgroup">TIDAK SESUAI<br /> KETENTUAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="5" style="text-align: center;">Checklist Kelengkapan Dokumen</th>
                                </tr>
                                <tr class="checklist">
                                    <td>
                                        <label for="suratPermintaanPembayaranSPP" class="col-form-label">Surat Permintaan
                                            Pembayaran SPP</label>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('/storage/files/' . $data->surat_permintaan_pembayaran_spp) }}"
                                            target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_surat_permintaan_pembayaran_spp"
                                            value="1"
                                            {{ $data->check_surat_permintaan_pembayaran_spp == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_surat_permintaan_pembayaran_spp"
                                            value="2"
                                            {{ $data->check_surat_permintaan_pembayaran_spp == 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_surat_permintaan_pembayaran_spp"
                                            value="3"
                                            {{ $data->check_surat_permintaan_pembayaran_spp == 3 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr class="checklist">
                                    <td>
                                        <label for="rab" class="col-form-label">Rencana Anggaran Biaya</label>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('/storage/files/' . $data->rab) }}" target="_blank">Lihat File
                                            <i class="fa fa-share-square"></i></a>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_rab" value="1"
                                            {{ $data->check_rab == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_rab" value="2"
                                            {{ $data->check_rab == 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_rab" value="3"
                                            {{ $data->check_rab == 3 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr class="checklist">
                                    <td>
                                        <label for="pernyataanPertanggungJawaban" class="col-form-label">Pernyataan
                                            Pertanggung
                                            Jawaban</label>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('/storage/files/' . $data->pernyataan_pertanggungjawaban) }}"
                                            target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_pernyataan_pertanggungjawaban"
                                            value="1"
                                            {{ $data->check_pernyataan_pertanggungjawaban == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_pernyataan_pertanggungjawaban"
                                            value="2"
                                            {{ $data->check_pernyataan_pertanggungjawaban == 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_pernyataan_pertanggungjawaban"
                                            value="3"
                                            {{ $data->check_pernyataan_pertanggungjawaban == 3 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr class="checklist">
                                    <td>
                                        <label for="dpa" class="col-form-label">Belanja DPA</label>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('/storage/files/' . $data->belanja_dpa) }}"
                                            target="_blank">Lihat File
                                            <i class="fa fa-share-square"></i></a>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_belanja_dpa" value="1"
                                            {{ $data->check_belanja_dpa == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_belanja_dpa" value="2"
                                            {{ $data->check_belanja_dpa == 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_belanja_dpa" value="3"
                                            {{ $data->check_belanja_dpa == 3 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr class="checklist">
                                    <td>
                                        <label for="skTimPelaksana" class="col-form-label">SK Tim Pelaksana</label>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('/storage/files/' . $data->sk_tim_pelaksana) }}"
                                            target="_blank">Lihat
                                            File <i class="fa fa-share-square"></i></a>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_sk_tim_pelaksana"
                                            value="1" {{ $data->check_sk_tim_pelaksana == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_sk_tim_pelaksana"
                                            value="2" {{ $data->check_sk_tim_pelaksana == 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_sk_tim_pelaksana"
                                            value="3" {{ $data->check_sk_tim_pelaksana == 3 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr class="checklist">
                                    <td>
                                        <label for="skDasarKegiatan" class="col-form-label">SK Dasar Kegiatan</label>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('/storage/files/' . $data->sk_dasar_kegiatan) }}"
                                            target="_blank">Lihat
                                            File <i class="fa fa-share-square"></i></a>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_sk_dasar_kegiatan"
                                            value="1" {{ $data->check_sk_dasar_kegiatan == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_sk_dasar_kegiatan"
                                            value="2" {{ $data->check_sk_dasar_kegiatan == 2 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_sk_dasar_kegiatan"
                                            value="3" {{ $data->check_sk_dasar_kegiatan == 3 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" style="text-align: center;">Checklist Persyaratan Lainnya</th>
                                    <th>ADA</th>
                                    <th>TIDAK ADA</th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="check_lapor_pertanggungjawaban" class="col-form-label">
                                            Semua pekerjaan/kegiatan sebelumnya telah dilaksanakan dilaporkan
                                            dipertanggungjawabkan sesuai Peraturan Perundang-undangan.
                                        </label>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_lapor_pertanggungjawaban"
                                            value="1"
                                            {{ $data->check_lapor_pertanggungjawaban == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_lapor_pertanggungjawaban"
                                            value="2"
                                            {{ $data->check_lapor_pertanggungjawaban == 2 ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="check_patuh_kebijakan" class="col-form-label">
                                            Mematuhi kebijakan-kebijakan Pemerintah Kabupaten, Pemerintah Provinsi,
                                            Pemerintah Pusat, dan/atau amar putusan Pengadilan Tata Usaha Negara.
                                        </label>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_patuh_kebijakan" value="1"
                                            {{ $data->check_patuh_kebijakan == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input class="" type="radio" name="check_patuh_kebijakan" value="2"
                                            {{ $data->check_patuh_kebijakan == 2 ? 'checked' : '' }}>
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
                                <tr>
                                    <td>
                                        <label for="anggaran_setuju" class="col-form-label">Anggaran Disetujui</label>
                                    </td>
                                    <td colspan="4">
                                        <input class="form-control" name="anggaran_setuju" id="anggaran_setuju"
                                            value="{{ old('anggaran_setuju', $data->anggaran_setuju) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="verifikator" class="col-form-label">TTD Verifikator ?</label>
                                    </td>
                                    <td colspan="4">
                                        <input type="checkbox" name="verifikasi" id="verifikasi"
                                            {{ $verif == '1' ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="4">
                                        <button type="submit" class="btn btn-success">VERIFIKASI</button>
                                        <input action="action" onclick="window.history.go(-1); return false;"
                                            type="submit" value="BATAL" class="btn btn-danger">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();

            var nominal = document.getElementById("anggaran_setuju");
            nominal.addEventListener("keyup", function(e) {
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatNominal() untuk mengubah angka yang di ketik menjadi format angka
                nominal.value = formatNominal(this.value);
            });
        });
    </script>
@endpush
