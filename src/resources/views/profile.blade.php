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
<form class="profile-form form-field" action="" enctype="multipart/form-data">
    @csrf
    <h1 class="content__heading">プロフィール設定</h1>
    <div class="profile__image--upload">
        <div class="user__image">
            <img class="uploaded__image"src="" alt="">
        </div>
        <div class="upload__image-field">
            <button class="upload__image-btn" type="button">
                <label for="upload__image">画像を選択する</label>
            </button>
            <input type="file" id="upload__image" name="image" style="display: none;">
        </div>
    </div>
    <div class="form__group">
        <label class="input-label" for="name">ユーザー名</label>
        <input class="input-window" type="text" name="name" id="name" value="{{ Auth::user()->name }}">
        <p class="error-message">
            @error('name')
            {{ $message }}
            @enderror
        </p>
    </div>
    <div class="form__group">
        <label class="input-label" for="postal_code">郵便番号</label>
        <input class="input-window" type="text" name="postal_code" id="postal_code" value="{{ Auth::user()->postal_code }}">
        <p class="error-message">
            @error('postal_code')
            {{ $message }}
            @enderror
        </p>
    </div>
    <div class="form__group">
        <label class="input-label" for="address">住所</label>
        <input class="input-window" type="text" name="address" id="address" value="{{ Auth::user()->address }}">
        <p class="error-message">
            @error('address')
            {{ $message }}
            @enderror
        </p>
    </div>
    <div class="form__group">
        <label class="input-label" for="building">建物名</label>
        <input class="input-window" type="text" name="building" id="building" value="{{ Auth::user()->building }}">
        <p class="error-message">
            @error('building')
            {{ $message }}
            @enderror
        </p>
    </div>

    <button class="submit-btn">更新する</button>

</form>
@endsection('content')