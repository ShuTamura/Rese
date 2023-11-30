<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>

<body class="menu-container">
    <header class="header">
        <a href="{{ url()->previous() }}" class="back">
            <span class="back__btn"></span>
        </a>
    </header>
    <main class="main">
        <ul class="menu__list">
            @if( Auth::check() )
            <li class="menu__item"><a href="/">Home</a></li>
            <li class="menu__item"><a href="/logout">Logout</a></li>
            <li class="menu__item"><a href="/mypage">Mypage</a></li>
            @foreach($user->roles as $role)
            @if($role->id == 1)
            <li class="menu__item"><a href="/admin/0">Admin Page</a></li>
            @endif
            @if($role->id == 2)
            <li class="menu__item"><a href="/rep">For Store Representative</a></li>
            @endif
            @endforeach

            @else
            <li class="menu__item"><a href="/">Home</a></li>
            <li class="menu__item"><a href="/register">Registration</a></li>
            <li class="menu__item"><a href="/login">Login</a></li>
            @endif
        </ul>
    </main>
</body>

</html>