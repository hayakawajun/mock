@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('content')
<div class="content">
    <form class="profile-form form-field" action="/profile_update" enctype="multipart/form-data" method="post">
        @csrf
        <h2 class="content__heading">プロフィール設定</h2>
        <div class="user-image">
            @isset($profile->image)
                <div class="uploaded__user-image">
                    <img src="{{ asset('storage/'.$profile->image) }}" alt="プロフィール画像">
                </div>
            @else
                <div class="uploaded__user-image">
                    <img src="{{ asset('image/default.png') }}" alt="デフォルトのプロフィール画像">
                </div>
            @endisset
                <div class="upload__image-field">
                    <label class="upload__image-btn" for="image"></label>
                    <input class="upload__image-input" type="file" name="image" id="image">
                </div>
        </div>
        <p class="error-message">
            @error('image')
            {{ $message }}
            @enderror
        </p>

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
            <input class="input-window" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code',$profile->postal_code ?? '') }}">
            <p class="error-message">
                @error('postal_code')
                {{ $message }}
                @enderror
            </p>
        </div>
        <div class="form__group">
            <label class="input-label" for="address">住所</label>
            <input class="input-window" type="text" name="address" id="address" value="{{ old('address',$profile->address ?? '') }}">
            <p class="error-message">
                @error('address')
                {{ $message }}
                @enderror
            </p>
        </div>
        <div class="form__group">
            <label class="input-label" for="building">建物名</label>
            <input class="input-window" type="text" name="building" id="building" value="{{ old('building',$profile->building ?? '') }}">
            <p class="error-message">
                @error('building')
                {{ $message }}
                @enderror
            </p>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button class="submit-btn">更新する</button>
    </form>
</div>
@endsection('content')