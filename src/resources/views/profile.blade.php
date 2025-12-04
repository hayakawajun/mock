@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('content')
<div class="content">

    <form class="form-field" action="{{ route('profile.update') }}" enctype="multipart/form-data" method="post">
        @csrf
        <h2 class="content__heading">プロフィール設定</h2>

        @error('image')
                <p class="error-message profile-image">{{ $message }}</p>
        @enderror

        <div class="user-image">
            @isset($profile->image)
                <div class="preview-container" id="preview-container">
                    <img class="preview-image" id="preview-image" src="{{ asset('storage/'.$profile->image) }}" alt="プロフィール画像">
                </div>
            @else
                <div class="preview-container" id="preview-container">
                    <img class="preview-image" id="preview-image" src="{{ asset('image/default.png') }}" alt="デフォルトのプロフィール画像">
                </div>
            @endisset
            <div class="upload__field">
                <label class="upload__item-image--btn" for="file-upload">画像を選択する</label>
                <input class="upload__item-image--input" type="file" name="image" id="file-upload" accept="image/*">
                <p class="file-name" id="file-name__display"></p>
            </div>
        </div>

        <div class="form__group">
            <label class="input-label" for="name">ユーザー名</label>
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="name" id="name" value="{{ Auth::user()->name }}">
        </div>

        <div class="form__group">
            <label class="input-label" for="postal_code">郵便番号</label>
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code',$profile->postal_code ?? '') }}">
        </div>

        <div class="form__group">
            <label class="input-label" for="address">住所</label>
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="address" id="address" value="{{ old('address',$profile->address ?? '') }}">
        </div>

        <div class="form__group">
            <label class="input-label" for="building">建物名</label>
            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="building" id="building" value="{{ old('building',$profile->building ?? '') }}">
        </div>

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button class="submit-btn">
            @empty($profile)
                登録する
            @else
                更新する
            @endempty
        </button>

    </form>

</div>

<script src="{{ asset('js/upload_profile.js') }}"></script>
@endsection('content')