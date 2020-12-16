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
                  <x-ui.layout.header-link route="login">Login</x-ui.layout.header-link>    
                @endif
            @else

                @can(['manage-tasks'])
                    <x-ui.layout.header-link route="tasks.create">New Task</x-ui.layout.header-link>
                @endcan
                @can(['create-users'])
                    <x-ui.layout.header-link route="users.create">New User</x-ui.layout.header-link>
                @endcan

                <li class="nav-item"><a class="nav-link">|</a></li>

                <x-ui.layout.header-link route="home.index">Home</x-ui.layout.header-link>
                @can('view-own-tasks')
                    <x-ui.layout.header-link route="myTasks.index">MyTasks</x-ui.layout.header-link>
                @endcan
                @can('view-own-team')
                    <x-ui.layout.header-link route="myTeam.index">My Team</x-ui.layout.header-link>
                @endcan
                @can('view-teams')
                    <x-ui.layout.header-link route="teams.index">Teams</x-ui.layout.header-link>
                @endcan
                <x-ui.layout.header-link-logout>Logout</x-ui.layout.header-link-logout>
            @endguest
        </ul>
    </div>
</nav>