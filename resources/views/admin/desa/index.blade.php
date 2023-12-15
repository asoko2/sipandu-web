@extends('layout.app')
@section('title', 'Master Desa')
@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Master Desa</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Master Desa</li>
        </ol>
    </div><!-- /.col -->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('tambah-desa') }}" class="btn btn-primary"><i
                            class="fas fa-plus fa-sm"></i>&nbsp;&nbsp;Desa</a>
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
                                <th>Kode Desa</th>
                                <th>Nama Desa</th>
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
                    "url": "{{ route('get-desa-json') }}",
                    "type": "POST",
                },
                //Set column definition initialisation properties.
                "columnDefs": [{
                        "targets": [0, 3], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                    {
                        "targets": [3],
                        "width": "15%",
                    },
                ],
                columns: [{
                        data: "no",
                        name: "no",
                    },
                    {
                        data: "kode_desa",
                        name: "kode_desa",
                    },
                    {
                        data: "nama_desa",
                        name: "nama_desa",
                    },
                    {
                        data: "action",
                        name: "action"
                    }
                ],
            });

            $('#example1').on('click', '#btn-hapus', function() {
                var id = $(this).data('id')

                $.ajax({
                    url: '{{ route('get-desa-by-id') }}',
                    method: 'post',
                    type: 'ajax',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(desa) {
                        Swal.fire({
                            title: 'WARNING!!!',
                            text: `Apakah anda yakin akan menghapus desa ${desa.nama_desa} ?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Hapus!',
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '{{ route('delete-desa-by-id') }}',
                                    method: 'post',
                                    type: 'ajax',
                                    data: {
                                        id: desa.id
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        Swal.fire(
                                            'Deleted!',
                                            `Berhasil hapus desa ${desa.nama_desa}.`,
                                            'success'
                                        )

                                        table.ajax.reload()
                                    },
                                    error: function(err) {
                                        Swal.fire(
                                            'Gagal Hapus',
                                            `Gagal Hapus desa ${desa.nama_desa}`,
                                            'error'
                                        )
                                    }
                                })
                            } else {
                                Swal.fire(
                                    'Dibatalkan',
                                    `Hapus desa ${data.nama_desa} dibatalkan`,
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
