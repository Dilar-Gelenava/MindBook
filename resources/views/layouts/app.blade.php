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
    <link rel="stylesheet" type="text/css" href="css/main.css">
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
            https://i.pinimg.com/originals/ad/47/af/ad47af29ad50df1477b9413f9d521db0.jpg
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
                <a style="transform: translate(8px)" class="navbar-brand" href="{{ url('/') }}"> MindBook </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="navbar-brand" href="{{ url('/home') }}"> Home </a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="{{ url('/myprofile') }}"> My Profile </a>
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
                        <img height="50px" width="50px" style="border-radius: 50px;" src="https://scontent.ftbs5-1.fna.fbcdn.net/v/t1.0-1/cp0/p50x50/122174109_178370813883145_8887753915068651092_o.jpg?_nc_cat=100&ccb=2&_nc_sid=7206a8&_nc_eui2=AeGzlaDhSvFVIO9KZtubzbm9osEa2p_GR3CiwRran8ZHcJFM8at-bl95foCEZ7zXtO5jynqKHjsLKngQA5b4BXLP&_nc_ohc=WrtwhjjXR24AX9PAyd2&_nc_ht=scontent.ftbs5-1.fna&tp=27&oh=bcc579be82fe0cefd4a22806cf6744b8&oe=5FC8C2B6">
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
