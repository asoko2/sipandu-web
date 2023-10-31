<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title') - SiPandu
    </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href=https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.min.css') }}">
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('sweetalert/sweetalert2.all.min.css') }}">

    @stack('style')



    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script>
        //AJAX SETUP
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //END AJAX SETUP
    </script>
    @yield('beforeReady')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('loading.gif') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link btn btn-primary text-white" data-toggle="dropdown" href="#">
                        <b>
                            {{ Auth::user()->name }}
                        </b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ url('change-password') }}" class="dropdown-item">
                            <!-- Message Start -->
                            Ubah Password
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('logout') }}" class="dropdown-item">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <div class="flex w-full justify-center items-center">
                <a href="index3.html" class="brand-link w-full items-center justify-center">
                    <span class="brand-text font-weight-light">SIPANDU</span>
                </a>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/boxed-bg.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{ Auth::user()->name }}
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        id="sidebar-menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
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
                        <li class="nav-item">
                            <a href="{{ url("/${role}/dashboard") }}"
                                class="nav-link {{ $nav == 'dashboard' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if ($role === 'admin')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        Master Data
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('admin/master-role') }}"
                                            class="nav-link {{ $nav == 'master-role' ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Master Role</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/master-desa') }}"
                                            class="nav-link {{ $nav == 'master-desa' ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Master Desa</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/master-user') }}"
                                            class="nav-link {{ $nav == 'master-user' ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Master User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('admin/master-anggaran') }}"
                                            class="nav-link {{ $nav == 'master-anggaran' ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Master Anggaran</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif ($role === 'verifikator')
                            <li class="nav-item">
                                <a href="{{ url('/verifikator/verifikasi') }}"
                                    class="nav-link {{ $nav == 'verifikasi' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Verifikasi Ajuan
                                    </p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ url('/operator/pengajuan') }}"
                                    class="nav-link {{ $nav == 'pengajuan' ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-pen-square"></i>
                                    <p>
                                        Pengajuan
                                    </p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ url('/operator/rekap-pengajuan') }}"
                                    class="nav-link {{ $nav == 'rekap-pengajuan' ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-print"></i>
                                    <p>
                                        Rekap Pengajuan
                                    </p>
                                </a>
                            </li> --}}
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

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
        <footer class="main-footer">
            <strong>Copyright &copy;</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    {{-- Sweetalert --}}
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>

    <script text="text/javascript">
        $(document).ready(function() {
            var element = $('#sidebar-menu > li > ul > li > a.active')

            element.parent().parent().parent().addClass('menu-open');
            element.parent().parent().parent().children('a').addClass('active');
        })
    </script>

    @stack('script')
</body>

</html>
