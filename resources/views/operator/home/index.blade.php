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
        <div class="col-lg-4 col-6" bis_skin_checked="1">
            <!-- small box -->
            <div class="small-box bg-lightblue" bis_skin_checked="1">
                <div class="inner" bis_skin_checked="1">
                    <h3>Rp. {{ $total_anggaran }}</h3>

                    <p>Total Anggaran</p>
                </div>
                <div class="icon" bis_skin_checked="1">
                    <i class="ion ion-cash"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6" bis_skin_checked="1">
            <!-- small box -->
            <div class="small-box bg-success" bis_skin_checked="1">
                <div class="inner" bis_skin_checked="1">
                    <h3>Rp. {{ number_format($total_realisasi, 2, ',', '.') }}</h3>

                    <p>Total Realisasi</p>
                </div>
                <div class="icon" bis_skin_checked="1">
                    <i class="ion ion-cash"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6" bis_skin_checked="1">
            <!-- small box -->
            <div class="small-box bg-warning" bis_skin_checked="1">
                <div class="inner" bis_skin_checked="1">
                    <h3>{{ $total_ajuan }}</h3>

                    <p>Total Usulan</p>
                </div>
                <div class="icon" bis_skin_checked="1">
                    <i class="ion ion-email"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
