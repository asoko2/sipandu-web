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
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-default color-palette-box">
                        <div class="card-body">
                            <p>Halo User, {{ Auth::user()->name }}.</p>
                            <h3>Selamat datang di Aplikasi <b>SiPandu</b></h3>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-default color-palette-box">
                        <div class="card-body">
                            <h3>Anda memiliki <span class="font-weight-bold text-red" style="font-size: 2.5rem">{{ $unverified_usulan_count }}</span> usulan yang belum diverifikasi</h3>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>                
            </div>
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        <b>
                            Data Anggaran Desa
                        </b>
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="anggaransChart"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <!-- right col -->
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('anggaransChart')

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $nama_desa; ?>,
                datasets: [{
                        label: 'Anggaran Desa',
                        data: <?php echo $anggaran_desa; ?>,
                        borderWidth: 1,
                        borderRadius: 6,
                        backgroundColor: 'rgba(88, 116, 248, 0.75)',
                    },
                    {
                        label: 'Realisasi Desa',
                        data: <?php echo $realisasi_desa; ?>,
                        borderWidth: 1,
                        borderRadius: 6,
                        backgroundColor: 'rgba(23, 255, 35, 0.75)',
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
