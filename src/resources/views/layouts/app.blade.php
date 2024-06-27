<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a class="header__logo" href="/">
                    Atte
                </a>
                <nav>
                    <ul class="header-nav">
                        @if (Auth::check())
                        <li class="header-nav__item">
                             <form class="home-form" action="/" method="get">
                            @csrf
                            <button class="header-nav__link">ホーム</button>
                            </form>
                        </li>
                        <li class="header-nav__item">
                             <form class="home-form" action="/attendance" method="get">
                            @csrf
                            <button class="header-nav__link">日付一覧</button>
                            </form>
                        </li>
                         <li class="header-nav__item">
                             <form class="home-form" action="/list" method="get">
                            @csrf
                            <button class="header-nav__link">ユーザー一覧</button>
                            </form>
                        </li>
                        <li class="header-nav__item">
                            <form class="logout-form" action="/logout" method="post">
                            @csrf
                            <button class="header-nav__link">ログアウト</button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer__inner">
            <a class="footer__logo">
            Atte,inc.
            </a>
        </div>
    </footer>
</body>

</html>