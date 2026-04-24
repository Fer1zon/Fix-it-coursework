<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href = "{{asset('assets/css/main.css')}}" rel="stylesheet">
</head>
<body>


<header class = "mb-1">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand ms-4 fs-2" style = "font-family: 'Fira-Sans-Condensed-Black'" href="{{route("index")}}">FIX-IT</a>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route("our_us")}}">О нас</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route("catalog")}}">Наши услуги</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="navbar bg-body-tertiary">

                    @if(!isset(Auth::user()->id))
                        <div class="container-fluid justify-content-start">
                            <a href = "/login" ><button class="btn btn-outline-success me-2" type="button">Вход</button></a>
                            <a href = "/register" ><button class="btn btn-sm btn-outline-secondary" type="button">Регистрация</button></a>
                        </div>
                    @else

                        <form class="container-fluid justify-content-start" action = "{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger me-2" type="submit">Выход</button>
                            <a href = "{{route('profile')}}"><button class = "btn btn-outline-success me-2" type="button">Профиль</button></a>
                        </form>





                   @endif


            </nav>
        </div>
    </nav>
</header>


<main class="py-4">
    @yield('content')
</main>

<footer class = "container-fluid d-flex justify-content-around w-75" style="border-top: #2b3035 solid; margin-top: 200px">

    <a href = '{{route('index')}}' class = "nav-link"><p style="font-family: Fira-Sans-Condensed-Black; font-size: 16px">Главная</p></a>
    <a href = '#' class = "nav-link"><p style="font-family: Fira-Sans-Condensed-Black; font-size: 16px">Услуги</p></a>
    <a href = '#' class = "nav-link"><p style="font-family: Fira-Sans-Condensed-Black; font-size: 16px">О нас</p></a>
</footer>
</body>
</html>
