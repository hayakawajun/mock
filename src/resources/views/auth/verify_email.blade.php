<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/verify_email.css') }}">
</head>

<body>

    <div class="app">

        <header class="header">
            <div class="header__content">
                <img src="{{ asset('image/logo.svg') }}" alt="coachtech">
            </div>
        </header>

        <div class="content">
            <p class="information">登録していただいたメールアドレスに認証メールを送付しました。</br>
            メール認証を完了してください。</p>
            <a class="mail__verification" href="http://localhost:8025/">認証はこちらから</a>
            <form action="{{ route('verification.send') }}" method="post">
                @csrf
                <button class="resending-email__button" type="submit">認証メールを再送する</button>
            </form>
        </div>

    </div>

</body>

</html>