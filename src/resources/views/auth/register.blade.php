@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('link')
<form class="search__form" action="">
    @csrf
    <input class="search__form--input" type="text" placeholder="なにをお探しですか？">
    <button class="search__form--btn">検索</button>
</form>
<nav class="header__nav">
    <a class="header__nav-link" href="">ログアウト</a>
    <a class="header__nav-link" href="">マイページ</a>
    <a class="header__nav-link" href="">出品</a>
</nav>
@endsection

@section('content')
<form class="login-form form-field" action="" >
    @csrf
    <h1 class="form__heading">会員登録</h1>
    <div class="form__group">
        <label class="input-label" for="name">ユーザー名</label>
        <input class="input-window" type="text" name="name" id="name" placeholder="例:山田太郎">
    </div>
    <div class="form__group">
        <label class="input-label" for="email">メールアドレス</label>
        <input class="input-window" type="text" name="email" id="email" placeholder="例:test@example.com">
    </div>
    <div class="form__group">
        <label class="input-label" for="password">パスワード</label>
        <input class="input-window" type="password" name="password" id="password" required autocomplete="new-password">
    </div>
    <div class="form__group">
        <label class="input-label" for="password_confirmation">確認用パスワード</label>
        <input class="input-window" type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
    </div>
    <button class="submit-btn">登録する</button>
    <a class="page-change" href="/login">ログインはこちら</a>
</form>
@endsection('content')