@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
    <div class="content">
        <form class="register-form form-field" action="{{ route('address.store',$item->id) }}" method="post">
            @csrf
            <h2 class="content__heading">配送先住所の登録</h2>
            <div class="form__group">
                <label class="input-label" for="postal_code">郵便番号</label>
                <input class="input-window" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}">
                <p class="error-message">
                    @error('postal_code')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <label class="input-label" for="address">住所</label>
                <input class="input-window" type="text" name="address" id="address" value="{{ old('address') }}">
                <p class="error-message">
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <label class="input-label" for="building">建物名</label>
                <input class="input-window" type="text" name="building" id="building" value="{{ old('building') }}">
                <p class="error-message">
                    @error('building')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <button class="submit-btn">
                登録する
            </button>
        </form>
    </div>
@endsection('content')