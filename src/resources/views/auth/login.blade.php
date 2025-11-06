@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="content">

    <form class="login-form form-field" action="/login" method="post" >
        @csrf
        <h2 class="content__heading">ログイン</h2>

        <div class="form__group">
            <label class="input-label" for="email">メールアドレス</label>
            <input class="input-window" type="text" name="email" id="email" placeholder="例:test@example.com">
            <p class="error-message">
                @error('email')
                {{ $message }}
                @enderror
            </p>
        </div>

        <div class="form__group">
            <label class="input-label" for="password">パスワード</label>
            <input class="input-window" type="password" name="password" id="password">
            <p class="error-message">
                @error('password')
                {{ $message }}
                @enderror
            </p>
        </div>

        <button class="submit-btn">ログインする</button>
        <a class="page-change" href="register">会員登録はこちら</a>

    </form>

</div>
@endsection('content')