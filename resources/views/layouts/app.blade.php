<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.url', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ config('app.url').'/js/app.js' }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ config('app.url').'/css/app.css' }}" rel="stylesheet">
    <style>
        .bodystyle{
            background: url({{config('app.url').'images/utpbg.jpg'}}) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
        }
    </style>
    @stack('styles')
</head>
<body class="bodystyle">{{-- style="background: url('/images/utpbg.jpg') no-repeat cover;" --}}
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="background-color: #2E3338">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    <img style="max-width:100px;" src="{{config('app.url').'/images/logoutp.png'}}">&nbsp;|&nbsp;{{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('home')}}">Home</a>
                        </li>
                        @guest
                        @else
                            @switch(Auth::user()->role->id)
                                @case(1)
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('location.index')}}">Locations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('equipment.index')}}">Equipments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('role.index')}}">Roles</a>
                                    </li>
                                    @break
                                @case(2)
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('application.index')}}">All Applications</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('calender.index')}}">Calender (IF)</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('system.index')}}">System</a>
                                    </li>
                                    @break
                                @case(3)
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('calender.index')}}">Calender</a>
                                    </li>
                                    @break
                                @case(4)
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('booking.create')}}">New Booking</a>
                                    </li>
                                    @break
                                @default
                            @endswitch
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto text-white">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @stack('scripts')
</body>
</html>
