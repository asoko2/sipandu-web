@extends('layout.app')
@section('title', 'Tambah Desa')
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Tambah Desa</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/master-desa') }}">Master Desa</a></li>
            <li class="breadcrumb-item active">Tambah Desa</li>
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
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('message'))
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form class="form-horizontal" action="{{ route('store-desa') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="kode_desa" class="col-sm-2 col-form-label">Kode Desa</label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" bis_skin_checked="1">
                                        <span class="input-group-text">35.22.20.</span>
                                    </div>
                                    <input type="text" class="form-control" name="kode_desa" id="kode_desa"
                                        placeholder="Kode Desa" value="{{ old('kode_desa') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_desa" class="col-sm-2 col-form-label">Nama Desa</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_desa" id="nama_desa"
                                    placeholder="Nama Desa" value="{{ old('nama_Desa') }}">
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
        $(function() {
            //   $("#example1").DataTable({
            //     "responsive": true
            //     , "lengthChange": false
            //     , "autoWidth": false
            //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            //   $('#example2').DataTable({
            //     "paging": true
            //     , "lengthChange": false
            //     , "searching": false                   
            //     , "ordering": true
            //     , "info": true
            //     , "autoWidth": false
            //     , "responsive": true
            //   , });

            $('#example1').DataTable({
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
                        "targets": [0, 2], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                    {
                        "targets": [2],
                        "width": "15%",
                    },
                ],
                columns: [{
                        data: "no",
                        name: "no",
                    },
                    {
                        data: "desa",
                        name: "desa",
                    },
                    {
                        data: "action",
                        name: "action"
                    }
                ],
            });
        });
    </script>
@endpush
