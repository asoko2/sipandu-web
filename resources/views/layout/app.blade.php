@php
    $role = 0;
    if (Auth::user()->role_id == 1) {
        $role = 'admin';
    } elseif (Auth::user()->role_id == 2) {
        $role = 'verifikator';
    } else {
        $role = 'operator';
    }
@endphp

{{-- Head --}}
@include('layout.head')
{{-- End of head --}}

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('loading.gif') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('layout.header', ['role' => $role])
        <!-- /.navbar -->

        <!-- Sidebar -->
        @include('layout.sidebar', ['role' => $role])
        <!-- End of sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @yield('page-nav')
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Main row -->
                    @yield('content')
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('layout.footer')
        <!-- end of footer -->
