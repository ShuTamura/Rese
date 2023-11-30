<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}"></script>

    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body class="container">
    <main id="app" class="main">
        <div class="menu">
            <div class="menu__inner">
                <a href="/menu" class="hamburger">
                    <span class="hamburger__bar"></span>
                    <span class="hamburger__bar"></span>
                    <span class="hamburger__bar"></span>
                </a>
                <h1 class="title">Rese</h1>
            </div>
        </div>
        @yield('content')
    </main>
    @yield('js')
</body>
</html>