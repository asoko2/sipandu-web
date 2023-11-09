@extends('layout.app')
@section('title', 'Ubah Password')
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Ubah Password</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/operator/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Ubah Password</li>
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
                <form class="form-horizontal" action="{{ route('update-password') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="old_password" class="col-sm-2 col-form-label">Password Lama</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="old_password" id="old_password"
                                    placeholder="Password Lama" value="{{ old('old_password') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password Baru" value="{{ old('password') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                    placeholder="Konfirmasi Password Baru" value="{{ old('password_confirmation') }}">
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
