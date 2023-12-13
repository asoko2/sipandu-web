@php
    $notification = getNotification();

    $new_notification_count = getNewNotificationCount();

@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notification Dropdown -->
        @if ($role === 'operator')
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" onclick="openNotification(this)" href="#">
                    <i class="far fa-bell"></i>
                    @if ($new_notification_count > 0)
                        <span class="badge badge-warning navbar-badge" id="new_notification_count">
                            {{ $new_notification_count }}
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    @if(count($notification) == 0)
                        <div class="p-3 center">
                            No Notification
                        </div>
                    @endif

                    @foreach ($notification as $notif)
                        <a href="javascript:void(0)" class="dropdown-item">
                            <div class="row row-cols-3">
                                <div class="col-1">
                                    <i class="fas fa-circle fa-xs"></i>
                                </div>
                                <div class="col-10 text-wrap">
                                    {{ $notif->message }}
                                </div>
                                <div class="col-1">
                                    <span class="float-right text-muted text-sm">
                                        @php
                                            $time = getNotificationTimeDiff($notif);
                                            echo $time;
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                </div>
            </li>
        @endif
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
