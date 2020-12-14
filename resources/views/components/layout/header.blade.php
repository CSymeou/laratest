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
                  <x-ui.header-link route="login">Login</x-ui.header-link>    
                @endif
            @else
                @can(['manage-tasks', 'manage-users'])
                    <x-ui.header-link route="home.index">Home</x-ui.header-link>
                @endcan
                @can('view-own-tasks')
                    <x-ui.header-link route="myTasks.index">MyTasks</x-ui.header-link>
                @endcan
                @can('manage-team')
                    <x-ui.header-link route="teamUsers.index">My Team</x-ui.header-link>
                @endcan
                @can('view-teams')
                    <x-ui.header-link route="teams.index">Teams</x-ui.header-link>
                @endcan
                <x-ui.header-link-logout>Logout</x-ui.header-link-logout>
            @endguest
        </ul>
    </div>
</nav>