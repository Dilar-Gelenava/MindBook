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


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/registration.css">
    <link rel="stylesheet" type="text/css" href="../css/index_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&family=Roboto&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,300&family=Rajdhani:wght@500&family=Roboto&family=Squada+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Recursive:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&family=Roboto&family=Squada+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Francois+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <style>
        body {
            background-color: #18191a;
        }
    </style>

</head>
<body>

        <div class = 'whole-page'>
            <div class = 'navbar-container'>
                <nav class="navbar navbar-expand-lg navbar ">
                    <a class="navbar-bran" href="/home">MindBook</a>
                    <div class = 'navbar-container'>
                    </div>
                    @auth
                        <form action="{{ route('search') }}" method="POST" class="form-inline my-2 my-lg-0">
                            @csrf
                            <input name="userName" class="form-control-search" type="search" placeholder="Search MindBook" aria-label="Search" required>
                            <button class="find-button" type="submit" style = 'visibility: hidden;'>FND</button>
                        </form>
                        <ul class ='navbar-nav'>
                            <li>
                                <a href="/home" class = 'nav-link'>Home</a>
                            </li>
                            <li>
                                <a href="/profile/{{ auth()->id() }}" class='nav-link'>My Profile</a>
                            </li>
                            <li>
                                <a href="/{{ 'posts/'.Auth::user()->id }}" class = 'nav-link'>My posts</a>
                            </li>
                            <li>
                                <a href="{{ route('messages') }}" class = 'nav-link'>Messages</a>
                            </li>
                            <a href="/profile/{{ Auth::user()->id }}">
                                <img class="post-story-wrapper-image"
                                     src="/storage/profile_pictures/{{ Auth::user()->id }}.jpg" onerror="this.onerror=null; this.src='/default-avatar.jpg'">
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
                        </ul>
                    @endauth
                </nav>
            </div>
        </div>


        @yield('content')


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>



