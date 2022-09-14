<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Ghost Wallet - Multi-Asset Tracking App">
    <meta name="keywords" content="investment portfolio tracker,  portfolio tracker app, free portfolio tracker, stock portfolio tracker, best crypto portfolio tracker, portfolio tracker, crypto portfolio tracker, portfolio, asset tracker, portfolio tracking, investments, portfolio app, ghostwallet, ghost wallet, ghost-wallet, investment tracker">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="3 days">
    <meta name="author" content="Philipp Weinguny">
    <meta name="publisher" content="Philipp Weinguny">
    <meta name="copyright" content="Philipp Weinguny">
    <meta name="description" content="Ghost Wallet a Multi-Asset Tracking App.
        100% Free. Stay up to date and watch the growth of your investments.
                    Create your virtual portfolio and add your assets. 
                    Keep track of all your stocks, cryptocurrencys, bonds and more!
                    ">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Ghost Wallet - Multi Asset Tracking App') }}</title>

    <!-- Scripts --> 
    <script type="text/javascript" src="https://app.termly.io/embed.min.js" data-auto-block="on" data-website-uuid="2bb14e44-1e48-4b4d-9db2-cc2606ae9e49" ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>

<body>
    <!-- NAV -->
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
            @guest
                <a class="navbar-brand pl-4" href="{{ route('welcome') }}">
            @else
                <a class="navbar-brand pl-4" href="{{ route('home.index') }}">
            @endguest
                    <img src="{{ asset('img/pie-s.png') }}" alt="Logo" style=" width: 35px; height: 35px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            @guest
                            <a class="nav-link" href="{{ route('welcome') }}">{{ 'Ghost Wallet' }}</a>
                            @else
                            <a class="nav-link" href="{{ route('home.index') }}">{{ 'Ghost Wallet' }}</a>
                            @endguest
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.us.index') }}">{{ __('Contact') }}</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.us.index') }}">{{ __('Contact') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->first_name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main id="main" class="py-5 main-content">
            @yield('content')
        </main>
    </div>
    <!-- Footer -->
    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center pb-3 mb-3">
                <li class="nav-item"><a href="{{ route('home.index') }}" class="nav-link px-2 ">Home</a></li>
                <li class="nav-item"><a href="{{ route('contact.us.index') }}" class="nav-link px-2">Contact</a></li>
                <li class="nav-item"><a href="{{ route('legal') }}" class="nav-link px-2 ">Legal</a></li>
                <li class="nav-item"><a href="{{ route('disclaimer') }}" class="nav-link px-2">Disclaimer</a></li>
            </ul>
            <p class="text-center text-muted pb-3"><a href="www.weinguny.com" class="nav-link">&copy; 2022 Weinguny</a></p>
        </footer>
    </div>

</body>

</html>
