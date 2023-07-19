<div class="top-navbar-section">
    <div class="top-header-navbar">
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/userAccount*') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.users.account') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/UsersAccount.svg')}}"></span>
                            <span class="menu-title">Users Account</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.users.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/UsersManagement.svg')}}"></span>
                            <span class="menu-title">Users Management</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/userAccess*') ? 'active' : '' }}" href="{{ route('admin.userAccess.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/UsersAccess.svg')}}"></span>
                            <span class="menu-title">Users Access</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/userPending*') ? 'active' : '' }}" href="{{ route('admin.users.pending') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/UsersPending.svg')}}"></span>
                            <span class="menu-title">Users Pending</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/userNotification*') ? 'active' : '' }}" href="{{ route('admin.userNotification.create') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/UsersNotification.svg')}}"></span>
                            <span class="menu-title">Users Notification</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/staffManagement*') ? 'active' : '' }}" href="{{ route('admin.staffManagement.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/StaffManagement.svg')}}"></span>
                            <span class="menu-title">Staff Management</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/staffTimecard*') ? 'active' : '' }}" href="{{ route('admin.staffTimecard.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/UsersManagement.svg')}}"></span>
                            <span class="menu-title">Staff Timecards</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<br>