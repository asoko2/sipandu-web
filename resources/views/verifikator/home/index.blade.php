@extends('layout.app')
@section('title', 'Dashboard')
@section('page-nav')
<div class="col-sm-6">
  <h1 class="m-0">Dashboard</h1>
</div><!-- /.col -->
<div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
</div><!-- /.col -->
@endsection
@section('content')
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 ">
            <div class="card card-default color-palette-box">
                {{-- <div class="card-header">
                    <h3 class="card-title">
                        <b>
                            Dashboard
                        </b>
                    </h3>
                </div> --}}
                <div class="card-body">
                    <p>Halo User, {{ Auth::user()->name }}.</p>
                    <h3>Selamat datang di Aplikasi <b>SiPandu</b></h3>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <!-- right col -->
    </div>
@endsection
