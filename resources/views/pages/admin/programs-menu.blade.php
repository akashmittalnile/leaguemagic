<div class="top-navbar-section">
    <div class="top-header-navbar">
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/programClubDivisions*') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.programClubDivisions.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/conferences.svg')}}"></span>
                            <span class="menu-title">Teams</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/programClubDivisionSettings*') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.programClubDivisionSettings.index') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/divisions.svg')}}"></span>
                            <span class="menu-title">Divisions</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::is('admin/programLocations*') ? 'active' : '' }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/location-1.svg')}}"></span>
                            <span class="menu-title">Game Loaction</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.programLocations.index') }}">Game Loaction</a>
                            <a class="dropdown-item" href="{{ route('admin.programDates.index') }}">Game Dates</a>
                            <a class="dropdown-item" href="{{ route('admin.programSlots.index') }}">Game Times</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/competitions.svg')}}"></span>
                            <span class="menu-title">Competitions</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/positions.svg')}}"></span>
                            <span class="menu-title">Player Certification</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/certifications.svg')}}"></span>
                            <span class="menu-title">Coach Certification</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/clubRegistrations*') ? 'active' : '' }}" href="{{ route('admin.clubs.registrations') }}">
                            <span class="menu-icon"><img src="{{asset('public/admin/images/ClubRegistration.svg')}}"></span>
                            <span class="menu-title">Club Registration</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<br>