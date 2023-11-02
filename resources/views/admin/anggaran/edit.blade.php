@extends('layout.app')
@section('title', 'Edit Anggaran')
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Edit Anggaran</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/master-anggaran') }}">Master Anggaran</a></li>
            <li class="breadcrumb-item active">Edit Anggaran</li>
        </ol>
    </div><!-- /.col -->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
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
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('update-anggaran', ['id' => $data->id]) }}?_method=PUT"
                    method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nama_desa" class="col-sm-2 col-form-label">Desa</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_desa" id="nama_desa"
                                    value="{{ old('nama_desa', $data->nama_desa) }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_anggaran" class="col-sm-2 col-form-label">Total Anggaran</label>
                            <div class="col-sm-10">
                                @php
                                    $anggaran = number_format($data->total_anggaran, 2, ',', '.');
                                @endphp
                                <input type="text" class="form-control" name="total_anggaran" id="total_anggaran"
                                    placeholder="Total Anggaran" value="{{ old('total_anggaran', $anggaran) }}">
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
    <script>
        $(document).ready(function() {
            var nominal = document.getElementById("total_anggaran");
            nominal.addEventListener("keyup", function(e) {
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatNominal() untuk mengubah angka yang di ketik menjadi format angka
                nominal.value = formatNominal(this.value);
            });
        });
    </script>
@endpush
