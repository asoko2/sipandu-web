@extends('layout.app')
@section('title', 'Pengajuan Pencairan')
@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Pengajuan Pencairan</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/operator/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pengajuan Pencairan</li>
        </ol>
    </div><!-- /.col -->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('tambah-pengajuan') }}" class="btn btn-primary"><i
                            class="fas fa-plus fa-sm"></i>&nbsp;&nbsp;Pengajuan</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pengajuan</th>
                                <th>Nama</th>
                                <th>Desa</th>
                                <th>Surat Permintaan Pembayaran SPP</th>
                                <th>Rencana Anggaran Biaya (RAB)</th>
                                <th>Pernyataan Pertanggungjawaban</th>
                                <th>Belanja DPA</th>
                                <th>SK Tim Pelaksana</th>
                                <th>SK Dasar Kegiatan</th>
                                <th>SPJ</th>
                                <th>Anggaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "scrollY": "35vh",
                "scrollCollapse": true,
                language: {
                    processing: false,
                },
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "{{ route('get-ajuan-operator-json') }}",
                    "type": "POST",
                },
                //Set column definition initialisation properties.
                "columnDefs": [{
                        "targets": '_all', //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],
                columns: [{
                        data: "no",
                        name: "no",
                        width: '5%',
                    },
                    {
                        data: "kode_pengajuan",
                        name: "kode_pengajuan",
                    },
                    {
                        data: "name",
                        name: "name",
                    },
                    {
                        data: "nama_desa",
                        name: "nama_desa",
                    },
                    {
                        data: "surat_permintaan_pembayaran_spp",
                        name: "surat_permintaan_pembayaran_spp",
                    },
                    {
                        data: "rab",
                        name: "rab",
                    },
                    {
                        data: "pernyataan_pertanggungjawaban",
                        name: "pernyataan_pertanggungjawaban",
                    },
                    {
                        data: "belanja_dpa",
                        name: "belanja_dpa",
                    },
                    {
                        data: "sk_tim_pelaksana",
                        name: "sk_tim_pelaksana",
                    },
                    {
                        data: "sk_dasar_kegiatan",
                        name: "sk_dasar_kegiatan",
                    },
                    {
                        data: "spj",
                        name: "spj",
                    },
                    {
                        data: "anggaran",
                        name: "anggaran",
                    },
                    {
                        data: "status",
                        name: "status",
                    },
                    {
                        data: "action",
                        name: "action",
                        width: '8.5%',
                    }
                ],
            });

            $('#example1').on('click', '#btn-kirim', function() {
                var id = $(this).data('id')

                $.ajax({
                    url: '{{ route('get-ajuan-by-id') }}',
                    method: 'post',
                    type: 'ajax',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(ajuan) {
                        Swal.fire({
                            title: `Apakah anda yakin akan mengirim pengajuan ${ajuan.kode_pengajuan}?`,
                            text: 'Jika sudah dikirim pengajuan tidak bisa diedit lagi',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya!',
                            cancelButtonText: 'Tidak',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '{{ route('kirim-ajuan-by-id') }}',
                                    method: 'post',
                                    type: 'ajax',
                                    data: {
                                        id: ajuan.id
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        Swal.fire(
                                            'Sukses!',
                                            'Pengajuan berhasil dikirim',
                                            'success'
                                        )

                                        table.ajax.reload()
                                    },
                                    error: function(err) {
                                        Swal.fire(
                                            'Gagal Hapus',
                                            `Gagal mengirim pengajuan ${ajuan.kode_pengajuan}`,
                                            'error'
                                        )
                                    }
                                })
                            } else {
                                Swal.fire(
                                    'Dibatalkan',
                                    `Pengiriman pengajuan ${ajuan.kode_pengajuan} dibatalkan`,
                                    'error'
                                )
                            }
                        })
                    }
                })
            })

            $('#example1').on('click', '#btn-cancel', function() {
                var id = $(this).data('id')

                $.ajax({
                    url: '{{ route('get-ajuan-by-id') }}',
                    method: 'post',
                    type: 'ajax',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(ajuan) {
                        Swal.fire({
                            title: 'WARNING!!!',
                            text: `Apakah anda yakin akan membatalkan pengajuan ${ajuan.kode_pengajuan}?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya!',
                            cancelButtonText: 'Tidak',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '{{ route('cancel-ajuan-by-id') }}',
                                    method: 'post',
                                    type: 'ajax',
                                    data: {
                                        id: ajuan.id
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        Swal.fire(
                                            'Sukses!',
                                            'Pengajuan berhasil dibatalkan',
                                            'success'
                                        )

                                        table.ajax.reload()
                                    },
                                    error: function(err) {
                                        Swal.fire(
                                            'Gagal Hapus',
                                            `Gagal membatalkan pengajuan ${ajuan.kode_pengajuan}`,
                                            'error'
                                        )
                                    }
                                })
                            } else {
                                Swal.fire(
                                    'Dibatalkan',
                                    `Pengajuan ini tidak jadi dibatalkan`,
                                    'error'
                                )
                            }
                        })
                    }
                })
            })
        });
    </script>
@endpush
