<div class="top-navbar-section">
    <div class="top-header-navbar">
        <nav class="navbar navbar-expand-lg">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link {{ Request::is('admin/conference*') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.conference.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/conferences.svg')}}"></span>
                            <span class="menu-title">Conferences</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/regions*') ? 'active' : '' }}" href="{{ route('admin.regions.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/regions.svg')}}"></span>
                            <span class="menu-title">Regions</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/clubs*') ? 'active' : '' }}" href="{{ route('admin.clubs.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/clubs.svg')}}"></span>
                            <span class="menu-title">Clubs</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/seasons*') ? 'active' : '' }}" href="{{ route('admin.seasons.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/seasons.svg')}}"></span>
                            <span class="menu-title">Seasons</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/sports*') ? 'active' : '' }}" href="{{ route('admin.sports.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/sports.svg')}}"></span>
                            <span class="menu-title">Sports</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/certificates*') ? 'active' : '' }}" href="{{ route('admin.certificates.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/certifications.svg')}}"></span>
                            <span class="menu-title">Certifications </span>
                        </a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::is('admin/divisions*') ? 'active' : '' }}" href="{{ route('admin.divisions.index') }}" data-bs-toggle="dropdown" aria-expanded="true">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/divisions.svg')}}"></span>
                            <span class="menu-title">Divisions</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.divisions.index') }}">Divisions</a>
                            <a class="dropdown-item" href="{{ route('admin.levels.index') }}">Levels</a>
                            <a class="dropdown-item" href="{{ route('admin.groups.index') }}">Group</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/locations*') ? 'active' : '' }}" href="{{ route('admin.locations.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/locations.svg')}}"></span>
                            <span class="menu-title">Locations</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/positions*') ? 'active' : '' }}" href="{{ route('admin.positions.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/positions.svg')}}"></span>
                            <span class="menu-title">Positions</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/uniforms*') ? 'active' : '' }}" href="{{ route('admin.uniforms.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/uniforms.svg')}}"></span>
                            <span class="menu-title">Uniforms</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<br>