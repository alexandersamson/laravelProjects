<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">{{config('app.name', 'Rapportagetool')}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/posts">Posts</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/casefiles">Cases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/clients">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users">Users</a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if((new \App\Http\Controllers\PermissionsController)->checkPermission((new \App\Http\Controllers\PermissionsController)->getBitwiseValue('Moderator'))[0]['permission'] == true)
                        <li class="nav-item">
                            <a class="nav-link" href="/posts/create">New Post</a>
                        </li>
                    @endif
                    @if((new \App\Http\Controllers\PermissionsController)->checkPermission((new \App\Http\Controllers\PermissionsController)->getBitwiseValue('Investigator'))[0]['permission'] == true)
                        <li class="nav-item">
                            <a class="nav-link" href="/casefiles/create">New Case</a>
                        </li>
                    @endif
                    @if((new \App\Http\Controllers\PermissionsController)->checkPermission((new \App\Http\Controllers\PermissionsController)->getBitwiseValue('Relations'))[0]['permission'] == true)
                        <li class="nav-item">
                            <a class="nav-link" href="/clients/create">New Client</a>
                        </li>
                    @endif
                    @if((new \App\Http\Controllers\PermissionsController)->checkPermission((new \App\Http\Controllers\PermissionsController)->getBitwiseValue('Manager'))[0]['permission'] == true)
                        <li class="nav-item">
                            <a class="nav-link" href="/users/create">New User</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/users/{{Auth::id()}}">View Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>