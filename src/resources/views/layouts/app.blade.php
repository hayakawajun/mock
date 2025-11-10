<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>

    <div class="app">

        <header class="header">
            <div class="header__content">
                <a class="header-logo" href="{{ route('item.index') }}"><img src="{{ asset('image/logo.svg') }}" alt="coachtech"></a>
                <form class="search__form" action="/search" method="get">
                    @csrf
                    <input class="search__form--input" type="text" name="keyword" value="{{ old('keyword') }}" placeholder="なにをお探しですか？">
                    <button class="search__form--btn">検索</button>
                </form>

                @auth
                    <nav class="header__nav">
                        <form class="logout" action="/logout" method="post">
                            @csrf
                            <button class="logout__btn">ログアウト</button>
                            <a class="header__nav-link" href="{{ route('profile.index') }}">マイページ</a>
                            <a class="header__nav-link" href="{{ route('item.create') }}">出品</a>
                        </form>
                    </nav>
                @else
                    <nav class="header__nav">
                        <a class="header__nav-link" href="/login">ログイン</a>
                        <a class="header__nav-link" href="/register">会員登録</a>
                    </nav>
                @endauth

            </div>
        </header>

        @if(session('success'))
            <div class="alert">
                <div class="alert__content">
                    <p class="alert-message">{{ session('success')}}</p>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="alert__danger">
                <div class="alert__content">
                    <p class="alert-message">入力内容に誤りがあります</p>
                </div>
            </div>
        @endif

        @yield('content')

    </div>

</body>

</html>