@extends('layout.app')
@section('title', 'Pengajuan Anggaran')
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Pengajuan Anggaran</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/operator/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pengajuan Anggaran</li>
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
                <form class="form-horizontal" action="{{ route('store-user') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="suratPermintaanPembayaranSPP" class="col-sm-2 col-form-label">Surat Permintaan
                                Pembayaran SPP</label>
                            <div class="input-group col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="suratPermintaanPembayaranSPP">
                                    <label class="custom-file-label" for="suratPermintaanPembayaranSPP">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rab" class="col-sm-2 col-form-label">Rencana Anggaran Biaya</label>
                            <div class="input-group col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="rab">
                                    <label class="custom-file-label" for="rab">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pernyataanPertanggungJawaban" class="col-sm-2 col-form-label">Pernyataan Pertanggung
                                Jawaban</label>
                            <div class="input-group col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="pernyataanPertanggungJawaban">
                                    <label class="custom-file-label" for="pernyataanPertanggungJawaban">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dpa" class="col-sm-2 col-form-label">Belanja DPA</label>
                            <div class="input-group col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="dpa">
                                    <label class="custom-file-label" for="dpa">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="skTimPelaksana" class="col-sm-2 col-form-label">SK Tim Pelaksana</label>
                            <div class="input-group col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="skTimPelaksana">
                                    <label class="custom-file-label" for="skTimPelaksana">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="skDasarKegiatan" class="col-sm-2 col-form-label">SK Dasar Kegiatan</label>
                            <div class="input-group col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="skDasarKegiatan">
                                    <label class="custom-file-label" for="skDasarKegiatan">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
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
        });
    </script>
@endpush
