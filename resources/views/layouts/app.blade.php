<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand text-white d-flex align-items-center" href="{{ url('/') }}">
                    <img src="/images/1.png" style="max-height: 50px;" alt="">
                    <div>{{ config('app.name', 'Laravel') }}</div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @auth
                            <li class="nav-item mr-3">
                                <form action="{{route('search')}}" method="GET">
                                    <div class="md-form mt-0">
                                        <input class="form-control" type="text" placeholder="Поиск" aria-label="Search" name="query">
                                    </div>
                                </form>
                            </li>
                            @if (auth()->user()->is_admin)
                                <li class="nav-item mr-3">
                                    <a class="nav-link text-white" href="{{ route('requests.all') }}">Все заявки</a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link text-white" href="{{ route('requests.assigned') }}">Мои заявки</a>
                                </li>
                                @else
                                <li class="nav-item mr-3">
                                    <a class="nav-link text-white" href="{{ route('user.tickets') }}">Мои заявки</a>
                                </li>

                                <li class="nav-item mr-3">
                                    <a class="nav-link text-white" href="{{ route('request.create') }}">Создать заявку</a>
                                </li>
                             @endif
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Вход') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
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
                                        {{ __('Выйти') }}
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

        <main class="py-4 d-flex justify-content-center">
            @yield('content')
        </main>
    </div>
</body>
<footer id="footer">
    <div class="copyright">
        <p>&copy 2020 - {{ config('app.name', 'Laravel') }}</p>
    </div>
    <div class="social">
        <a href="#" class="support">Написать нам</a>
        <a href="#" class="face">f</a>
        <a href="#" class="tweet">t</a>
        <a href="#" class="linked">in</a>
    </div>
</footer>
</html>
