<aside class="main-sidebar sidebar-dark-primary">
    <a href="index3.html" class="brand-link d-flex justify-content-center">
        <img src="{{ asset('assets') }}/dashboard/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image-xl img-circle" style="opacity: 0.8" />
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item waves-effect mt-3" onclick="createRipple(event)">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item waves-effect" onclick="createRipple(event)">
                    <a href="/router" class="nav-link {{ Request::is('router') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-server"></i>
                        <p>Router</p>
                    </a>
                </li>

                <li class="nav-item dropdown-nav">
                    <a href="#" class="nav-link waves-effect dropdown-link" onclick="createRipple(event)">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            PPPOE
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/pppoe/profile" class="nav-link {{ Request::is('pppoe/profile') ? 'active' : '' }}">
                                <i class="nav-icon"></i>
                                <p class="pl-5">Profile PPPOE</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/pppoe/user" class="nav-link {{ Request::is('pppoe/user') ? 'active' : '' }}">
                                <i class="nav-icon"></i>
                                <p class="pl-5">User PPPOE</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
