<div class="header">
    <nav class="navbar">
        <div class="navbar-menu-wrapper">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link toggle-sidebar mon-icon-bg">
                        <img src="{{asset('public/admin/images/sidebartoggle.svg')}}">
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item profile-dropdown dropdown">
                    <a class="nav-link dropdown-toggle" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-pic"><img src="{{asset('public/admin/images/users.png')}}" alt="user"> </div>
                    </a>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">
                            <i class="las la-user"></i> Profile
                        </a>
                        <a href="{{ route('admin.logout') }}" class="dropdown-item" onclick="event.preventDefault();

                                                         document.getElementById('logout-form').submit();">

                            <i class="las la-sign-out-alt"></i> {{ __('Logout') }}
                        </a>
                    </div>
                </li>

            </ul>

            </ul>
        </div>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>
</div>