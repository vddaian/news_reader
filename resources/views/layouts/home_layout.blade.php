<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-style.css') }}">
    @stack('css')
</head>

<body>
    <nav class="navBlock">
        <ul class="navElementsList">
            <li><a href="{{ route('posts.index') }}">{{ __('Home') }}</a></li>

        </ul>
        <li><a href="{{ route('logout') }}">{{ __('Logout') }}</a></li>
        </ul>
    </nav>
    @yield('content')
</body>

</html>
