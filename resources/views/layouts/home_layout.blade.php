<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('css')
</head>

<body>
    <nav class="navbar navbar-expand-lg w-100 d-flex justify-content-end pe-3">
        <a href="{{ route('newsp.index') }}"><img src="{{ asset('media\ico\home_circle_icon_137496.png') }}"
                alt="home_ico" style="width:35px; height:35px;"></a></li>
        <a href="{{ route('logout') }}"><img src="{{ asset('media\ico\power-off.png') }}" alt="logout_ico" style="width:31px; height:31px;"></a>
    </nav>
    @yield('content')
</body>

</html>
