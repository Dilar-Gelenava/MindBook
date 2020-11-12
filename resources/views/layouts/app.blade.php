<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MindBook</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body {
            color: #969696;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        p, a, h1, h2, h3, h4, h5, h6 {
            color: white;
        }

        .links > a {
            color: #c8c8c8;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        body {
            background: url(
            https://wallpapercave.com/wp/wp5849659.png
            ) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        card-body{
            background-color: purple;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div style="border-radius: 15px; background-color: purple; margin-right: 20px;">
                <a style="transform: translate(8px)" class="navbar-brand" href="{{ url('/home') }}"> MindBook </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="navbar-brand" href="/profile/{{ Auth::user()->id }}"> My Profile </a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="/{{ 'posts/'.Auth::user()->id }}"> My Posts </a>
                    </li>
                    <li>
                        <form action="{{ route('search') }}" method="POST">
                            @csrf
                            <label>
                                <input type="text" name="userName" placeholder="Type username here...">
                            </label>
                            <button class="btn btn-success"> search </button>
                        </form>
                    </li>
                </ul>
                @endauth
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
                        <p style="margin-top: 10px; margin-right: 10px;">{{ Auth::user()->email }}</p>
                        <a href="/profile/{{ Auth::user()->id }}">
                            <img style="height: 50px; width: 50px; border-radius: 50%; border: 2px solid white; object-fit: cover;"
                                 src="/storage/profile_pictures/{{ Auth::user()->id }}.jpg" onerror="this.onerror=null; this.src='https://thumbs.dreamstime.com/b/default-avatar-profile-image-vector-social-media-user-icon-potrait-182347582.jpg'">
                        </a>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
