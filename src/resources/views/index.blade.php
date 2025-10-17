@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="tab-field">

    <input class="index__tab-button" type="radio" id= "index" name="tab-name" checked>
    <label class="tab-label left" for="index">おすすめ</label>
    @auth
    <input type="radio" class="mylist__tab-button" id="mylist" name="tab-name">
    <label class="tab-label" for="mylist">マイリスト</label>
    @endauth

    <div class="items__index">
        <div class="items">
            @foreach($items as $item)
                <div class="item">
                    <a class="item-img" href="">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="商品画像">
                    </a>
                    <a class="item-img__text" href="">{{ $item->name }}</a>
                </div>
            @endforeach
        </div>
    </div>

    @auth
        <div class="items__mylist">
            <div class="items">
                @isset($likes)
                    @foreach($likes as $like)
                        <div class="item">
                            <a class="item-img" href="">
                                <img src="{{ asset('storage/'.$like->image) }}" alt="商品画像">
                            </a>
                            <a class="item-img__text" href="">{{ $like->name }}</a>
                        </div>
                    @endforeach
                @else
                    <h2>まだ「いいね」している商品はありません。
                @endisset
            </div>
        </div>
    @endauth

</div>

<a href="/mypage/profile">プロフィール設定画面へ</a>
@endsection('content')