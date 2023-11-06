@extends('layout.app')
@section('title', 'Assign Verifikator')
@section('page-nav')
    <div class="col-sm-6">
        <h1 class="m-0">Assign Verifikator</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/master-user') }}">Master User</a></li>
            <li class="breadcrumb-item active">Assign Verifikator</li>
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
                <form class="form-horizontal" action="{{ route('assign-verifikator', $data->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="no" class="col-sm-2 col-form-label">No</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="no" id="no" placeholder="No"
                                    value="{{ old('no', $data->no) }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-2 col-form-label">Verifikator</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">-- Pilih Verifikator --</option>
                                    @php
                                        $query = DB::table('users')
                                            ->orderBy('id')
                                            ->where('role_id', 2)
                                            ->whereNotIn('id', function($query){
                                                $query->select('user_id')
                                                ->from('verifikators');
                                                // ->whereNot('user_id', $data->user_id);
                                            });
                                        $user = $query->get();
                                    @endphp
                                    @foreach ($user as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
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
                    "url": "{{ route('get-user-json') }}",
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
                        data: "user",
                        name: "user",
                    },
                    {
                        data: "action",
                        name: "action"
                    }
                ],
            });

            $('#role_id').on('change', function() {
                if ($(this).val() == 3) {
                    $('#kode_desa').attr('disabled', false)
                } else if ($(this).val() == 2) {
                    $('#kode_desa').attr('disabled', true)
                } else {
                    $('#kode_desa').attr('disabled', true)
                }
            })
        });
    </script>
@endpush
