@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="tab">
    <div class="tab-field">
        <input type="radio" id= "index" name="tab-name" checked>
        <label class="tab-label" for="index">おすすめ</label>
        @auth
        <input type="radio" id= "mylist" name="tab-name">
        <label class="tab-label mylist" for="mylist">マイリスト</label>
        @endauth
    </div>
</div>
<div class="items" id="items__index">
    <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
    <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
    <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
        <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
    <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
    <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
    <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
        <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
    <div class="item">
        <a class="item-img" href="">
            <img src="{{ asset('image/サンプル画像1.png') }}" alt="商品画像">
        </a>
        <a class="item-img__text" href="">商品名</a>
    </div>
</div>


    <a href="/mypage/profile">プロフィール設定画面へ</a>
@endsection('content')