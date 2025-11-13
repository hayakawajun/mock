@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="content">

    <form class="form-field" action="/register" method="post" >
        @csrf
        <h2 class="content__heading">会員登録</h2>

        <div class="form__group">
            <label class="input-label" for="name">ユーザー名</label>
            <input class="input-window" type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="input-label" for="email">メールアドレス</label>
            <input class="input-window" type="text" name="email" id="email" value="{{ old('email') }}">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="input-label" for="password">パスワード</label>
            <input class="input-window" type="password" name="password" id="password" required autocomplete="new-password">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="input-label" for="password_confirmation">確認用パスワード</label>
            <input class="input-window" type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button class="submit-btn">登録する</button>
        <a class="page-change" href="/login">ログインはこちら</a>

    </form>

</div>
@endsection('content')