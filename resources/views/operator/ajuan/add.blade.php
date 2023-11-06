@extends('layout.app')
@section('title', 'Pengajuan Anggaran')
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Tambah Pengajuan Anggaran</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/operator/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/operator/pengajuan') }}">Pengajuan Anggaran</a></li>
            <li class="breadcrumb-item active">Tambah Pengajuan Anggaran</li>
        </ol>
    </div><!-- /.col -->
@endsection
@section('content')
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
                <form class="form-horizontal" action="{{ route('store-ajuan') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="suratPermintaanPembayaranSPP" class="col-sm-3 col-form-label">Surat Permintaan
                                Pembayaran SPP</label>
                            <div class="input-group col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="suratPermintaanPembayaranSPP"
                                        name="suratPermintaanPembayaranSPP" required>
                                    <label class="custom-file-label" for="suratPermintaanPembayaranSPP">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rab" class="col-sm-3 col-form-label">Rencana Anggaran Biaya</label>
                            <div class="input-group col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="rab" name="rab" required>
                                    <label class="custom-file-label" for="rab">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pernyataanPertanggungJawaban" class="col-sm-3 col-form-label">Pernyataan Pertanggung
                                Jawaban</label>
                            <div class="input-group col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="pernyataanPertanggungJawaban"
                                        name="pernyataanPertanggungJawaban" required>
                                    <label class="custom-file-label" for="pernyataanPertanggungJawaban">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dpa" class="col-sm-3 col-form-label">Belanja DPA</label>
                            <div class="input-group col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="dpa" name="dpa" required>
                                    <label class="custom-file-label" for="dpa">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="skTimPelaksana" class="col-sm-3 col-form-label">SK Tim Pelaksana</label>
                            <div class="input-group col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="skTimPelaksana"
                                        name="skTimPelaksana" required>
                                    <label class="custom-file-label" for="skTimPelaksana">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="skDasarKegiatan" class="col-sm-3 col-form-label">SK Dasar Kegiatan</label>
                            <div class="input-group col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="skDasarKegiatan"
                                        name="skDasarKegiatan" required>
                                    <label class="custom-file-label" for="skDasarKegiatan">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="anggaran" class="col-sm-3 col-form-label">Anggaran yang diajukan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="anggaran" id="anggaran"
                                    placeholder="Contoh : 125.000.000" value="{{ old('anggaran') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-info">SIMPAN</button>
                            </div>
                        </div>
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
            var nominal = document.getElementById("anggaran");
            nominal.addEventListener("keyup", function(e) {
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatNominal() untuk mengubah angka yang di ketik menjadi format angka
                nominal.value = formatNominal(this.value);
            });
        });
    </script>
@endpush
