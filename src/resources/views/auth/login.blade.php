@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="content">

    <form class="form-field" action="/login" method="post" >
        @csrf
        <h2 class="content__heading">ログイン</h2>

        <div class="form__group">
            <label class="input-label" for="email">メールアドレス</label>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="email" id="email" placeholder="例:test@example.com">
        </div>

        <div class="form__group">
            <label class="input-label" for="password">パスワード</label>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="password" name="password" id="password">
        </div>

        <button class="submit-btn">ログインする</button>
        <a class="page-change" href="register">会員登録はこちら</a>

    </form>

</div>
@endsection('content')