
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">Payslip</a>
                        </li>
                    @endguest

                    @if(getLoggedUser()['role']['name'] == 'admin')
                        <li class="nav-item {{ request()->segment(1) == 'user' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.index') }}">Users</a>
                        </li>
                    @endif

                    <li class="nav-item {{ request()->segment(1) == 'student' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('student.index') }}">Students</a>
                    </li>

                    @if(getLoggedUser()['role']['name'] == 'admin')
                        <li class="nav-item {{ request()->segment(1) == 'subject' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('subject.index') }}">Subjects</a>
                        </li>
                    @endif

                    <li class="nav-item {{ request()->segment(1) == 'subject' ? 'active' : '' }}">
                        {{-- <a class="nav-link" href="{{ route('subject.index') }}"><span class="fa fa-power-off text-danger"></span></a> --}}
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sample User
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            {{-- <a class="dropdown-item" href="#">My Profile</a> --}}
                            {{-- <div class="dropdown-divider"></div> --}}
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
