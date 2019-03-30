<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CAL Lab Equipment Booking System (CALEBS)</title>

    <!-- Scripts -->
    <script src="{{ config('app.url').'/js/app.js' }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ config('app.url').'/css/app.css' }}" rel="stylesheet">
    <style>
        .bodystyle{
            background: url({{config('app.url').'/images/utpbg.jpg'}}) no-repeat center center fixed; 
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
                <a class="navbar-brand text-white" href="#">
                    <img style="max-width:100px;" src="{{config('app.url').'/images/logoutp.png'}}">&nbsp;|&nbsp; CAL Lab Equipment Booking System (CALEBS)
                </a>
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
