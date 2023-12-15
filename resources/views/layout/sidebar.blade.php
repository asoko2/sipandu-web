<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="flex w-full justify-center items-center">
        <a href="{{ url('/') }}" class="brand-link w-full items-center justify-center">
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" id="sidebar-menu"
                data-accordion="false">
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
                    <li class="nav-item">
                        <a href="{{ url('admin/setting-verifikator') }}"
                            class="nav-link {{ $nav == 'setting-verifikator' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-wrench"></i>
                            <p>
                                Setting Verifikator
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/rekap') }}" class="nav-link {{ $nav == 'rekap' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Rekap Pengajuan
                            </p>
                        </a>
                    </li>
                @elseif ($role === 'verifikator')
                    <li class="nav-item">
                        @php
                            $isVerifikator = DB::table('verifikators')
                                ->select('*')
                                ->where('user_id', Auth::user()->id)
                                ->first();
                        @endphp

                        @if ($isVerifikator)
                            <a href="{{ url('/verifikator/verifikasi') }}"
                                class="nav-link {{ $nav == 'verifikasi' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-check-double"></i>
                                <p>
                                    Verifikasi Ajuan
                                </p>
                            </a>
                        @else
                            <div class="nav-link">
                                <i class="nav-icon fas fa-check-double"></i>
                                <p>Verifikasi Ajuan</p>
                            </div>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/verifikator/rekap') }}" disabled
                            class="nav-link {{ $nav == 'rekap' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Rekap Pengajuan
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
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
