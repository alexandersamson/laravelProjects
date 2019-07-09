<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="{{url('/images/dfalogo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">&nbsp;{{config('app.name', 'Rapportagetool')}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{Request::is('home') ? 'active' : ''}}" href="/home">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('posts') ? 'active' : ''}}" href="/posts">Posts</a>
                </li>
                @auth
                    @hasanyrole('Investigator|Casemanager')
                        <li class="nav-item {{Request::is('casefiles') ? 'active' : ''}}">
                            <a class="nav-link" href="/casefiles">Cases</a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('Relations|Casemanager')
                        <li class="nav-item {{Request::is('clients') ? 'active' : ''}}">
                            <a class="nav-link" href="/clients">Clients</a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('Casemanager')
                        <li class="nav-item {{Request::is('subjects') ? 'active' : ''}}">
                            <a class="nav-link" href="/subjects">Subjects</a>
                        </li>
                    @endhasanyrole
                    @hasanyrole('Staff|Manager|Owner')
                        <li class="nav-item {{Request::is('users') ? 'active' : ''}}">
                            <a class="nav-link" href="/users">Users</a>
                        </li>
                    @endhasanyrole
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
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            New <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @hasanyrole('Investigator|Casemanager')
                                <a class="dropdown-item {{Request::is('casefiles/create') ? 'active' : ''}}" href="/casefiles/create">New Case</a>
                            @endhasanyrole
                            @hasanyrole('Relations')
                                <a class="dropdown-item {{Request::is('clients/create') ? 'active' : ''}}" href="/clients/create">New Client</a>
                            @endhasanyrole
                            @hasanyrole('Casemanager')
                            <a class="dropdown-item {{Request::is('subjects/create') ? 'active' : ''}}" href="/subjects/create">New Subject</a>
                            @endhasanyrole
                            @hasanyrole('Manager|Owner')
                                <a class="dropdown-item {{Request::is('users/create') ? 'active' : ''}}" href="/users/create">New User</a>
                            @endhasanyrole
                            <hr>
                            @hasanyrole('Staff|Moderator')
                                <a class="dropdown-item {{Request::is('posts/create') ? 'active' : ''}}" href="/posts/create">New Post</a>
                            @endhasanyrole
                            @hasanyrole('Staff')
                                <a class="dropdown-item {{Request::is('messages/create') ? 'active' : ''}}" href="/messages/create">Send Message</a>
                            @endhasanyrole
                        </div>
                    </li>

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