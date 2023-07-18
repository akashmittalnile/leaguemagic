<div class="sidebar-wrapper sidebar">
    <div class="sidebar-logo">
        <a href="index.html">
            <img class="" src="{{ asset('public/admin/images/logo.png') }}" alt="">
        </a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
    </div>
    <div class="sidebar-nav">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/settings') ? 'active' : '' }}" href="{{ route('admin.conference.index') }}">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/setting.svg') }}"></span>
                        <span class="menu-title">Settings</span>
                    </a>

                </li>
                <li class="nav-item {{ Request::is('admin/program*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.programs.index') }}">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/programs.svg') }}"></span>
                        <span class="menu-title">Programs</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/user*') ? 'active' : '' }}" href="{{ route('admin.users.account') }}">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/users.svg') }}"></span>
                        <span class="menu-title">Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/schedules.svg') }}"></span>
                        <span class="menu-title">Schedules</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/scores.svg') }}"></span>
                        <span class="menu-title">Scores</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/programs.svg') }}"></span>
                        <span class="menu-title">Standings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/playoffs.svg') }}"></span>
                        <span class="menu-title">Playoffs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/teams.svg') }}"></span>
                        <span class="menu-title">Teams</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/payments.svg') }}"></span>
                        <span class="menu-title">Payments</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/players.svg') }}"></span>
                        <span class="menu-title">Players</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/reports.svg') }}"></span>
                        <span class="menu-title">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/referees.svg') }}"></span>
                        <span class="menu-title">Referees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">
                        <span class="menu-icon"><img src="{{ asset('public/admin/images/logout.svg') }}"></span>
                        <span class="menu-title">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>