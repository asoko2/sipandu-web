@extends('layout.app')
@section('title', 'Pengajuan Anggaran')
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
                <form class="form-horizontal" action="{{ route('setuju-ajuan', $data->id) }}" method="POST"">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="suratPermintaanPembayaranSPP" class="col-sm-3 col-form-label">Surat Permintaan
                                Pembayaran SPP</label>
                            <div class="col-sm-9">
                                <a href="{{ URL::to('/storage/files/'.$data->surat_permintaan_pembayaran_spp) }}" target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rab" class="col-sm-3 col-form-label">Rencana Anggaran Biaya</label>
                            <div class="col-sm-9">
                                <a href="{{ URL::to('/storage/files/'.$data->rab) }}" target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pernyataanPertanggungJawaban" class="col-sm-3 col-form-label">Pernyataan Pertanggung
                                Jawaban</label>
                                <div class="col-sm-9">
                                    <a href="{{ URL::to('/storage/files/'.$data->pernyataan_pertanggungjawaban) }}" target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="dpa" class="col-sm-3 col-form-label">Belanja DPA</label>
                            <div class="col-sm-9">
                                <a href="{{ URL::to('/storage/files/'.$data->belanja_dpa) }}" target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="skTimPelaksana" class="col-sm-3 col-form-label">SK Tim Pelaksana</label>
                            <div class="col-sm-9">
                                <a href="{{ URL::to('/storage/files/'.$data->sk_tim_pelaksana) }}" target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="skDasarKegiatan" class="col-sm-3 col-form-label">SK Dasar Kegiatan</label>
                            <div class="col-sm-9">
                                <a href="{{ URL::to('/storage/files/'.$data->sk_dasar_kegiatan) }}" target="_blank">Lihat File <i class="fa fa-share-square"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-3 col-form-label">Catatan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-success">SETUJU</button>
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
