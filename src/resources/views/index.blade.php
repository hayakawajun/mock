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
                    <a class="item-img" href="/item/{{ $item->id }}">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="商品画像">
                    </a>
                    <a class="item-img__text" href="/item/{{ $item->id }}">{{ $item->name }}</a>
                    @if($item->purchase)
                        <span class="sold">SOLD</span>
                    @endif
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
                            <a class="item-img" href="/item/{{ $item->id }}">
                                <img src="{{ asset('storage/'.$like->image) }}" alt="商品画像">
                            </a>
                            <a class="item-img__text" href="/item/{{ $item->id }}">{{ $like->name }}</a>
                                @if($like->purchase)
                                    <span class="sold">SOLD</span>
                                @endif
                        </div>
                    @endforeach
                @endisset
                @if($likes->isEmpty())
                    @if(request()->filled('keyword'))
                        <h2>検索した商品で「いいね」しているものはありません。</h2>
                    @else
                        <h2>「いいね」している商品はありません。</h2>
                    @endif
                @endif
            </div>
        </div>
    @endauth

</div>

<a href="/mypage/profile">プロフィール設定画面へ</a>
@endsection('content')