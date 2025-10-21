@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('content')
<div class="split-content">

    <div class="left-content">

        <div class="item-img">
            <img src="{{ asset('storage/'.$item->image) }}" alt="商品画像">
        </div>

    </div>

    <div class="right-content">

        <div class="name">
            <h1 class="item-name">{{ $item->name }}</h1>
            @if($item->bland == 'なし')
                <p class="item-bland">ブランド名：不明</p>
            @elseif(empty($item->bland))
                <p class="item-bland">ブランド名：不明</p>
            @else
                <p class="item-bland">{{ $item->bland }}</p>
            @endif
            <p class="item-price"><span>&yen;</span>{{ number_format($item->price) }}<span> (税込)</span></p>
            <form class="icons" action="" method="post">
                @csrf
                <div class="icon">
                    @auth
                        @if($item->liked_by_user)
                            <button class="like__btn--colored"></button>
                        @else
                            <button class="like__btn"></button>
                        @endif
                    @else
                        <img src="{{ asset('image/星アイコン.png') }}" alt="星アイコン">
                    @endauth
                    <p>20</p>
                </div>
                <div class="icon">
                    <img src="{{ asset('image/ふきだしアイコン.png') }}" alt="ふきだしアイコン">
                    <p>50</p>
                </div>
            </form>
            @if($item->purchase)
                <p class="sold-out">SOLD</p>
            @else
                <a class="purchase__btn" href="">購入手続きへ</a>
            @endif
        </div>

        <div class="description">
            <h2>商品説明</h2>
            <p>{{ $item->description }}</p>
        </div>

        <div class="information">
            <h2>商品の情報</h2>
            <div class="categories">
                <div class="information-subtitle">
                    <h4>カテゴリー</h4>
                </div>
                <div class="category-names">
                    @foreach($item->categories as $category)
                        <span class="category-name">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="status">
                <div class="information-subtitle">
                    <h4>商品の状態</h4>
                </div>
                @if($item->status == 1)
                    <span class="item-status">良好</span>
                @elseif($item->status == 2)
                    <span class="item-status">目立った傷や汚れなし</span>
                @elseif($item->status == 3)
                    <span class="item-status">やや傷や汚れあり</span>
                @elseif($item->status == 4)
                    <span class="item-status">状態が悪い</span>
                @endif
            </div>
        </div>

        <div class="comments">
            <h2>コメント</h2>
        </div>

    </div>

</div>
@endsection('content')