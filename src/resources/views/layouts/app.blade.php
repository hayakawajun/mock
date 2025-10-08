<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtech</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="header__content">
                <a href="/"><img src="{{ asset('image/logo.svg') }}" alt="coachtech"></a>
                @yield('link')
            </div>
        </header>
        @if(session('success'))
            <div class="alert">
                <div class="alert__content">
                    <p class="alert-massage">{{ session('success')}}</p>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="alert__danger">
                <div class="alert__content">
                    <p class="alert-massage">入力内容に誤りがあります</p>
                </div>
            </div>
        @endif
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>

</html>