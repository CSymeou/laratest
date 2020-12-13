<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('myTasks.index') ? 'active' : '' }}" href="{{ route('myTasks.index') }}">My Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('teamUsers.index') ? 'active' : '' }}" href="{{ route('teamUsers.index') }}">My Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('teamLeaders.index') ? 'active' : '' }}" href="{{ route('teamLeaders.index') }}">Team Leaders</a>
                </li>
            @else
                <li class="nav-item dropdown">

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>