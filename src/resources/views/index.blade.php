@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="tabs">

    <input class="index__tab-button" type="radio" id= "index" name="tab-name" checked>
    <label class="tab-label left" for="index">おすすめ</label>
    @auth
        <input class="mylist__tab-button" type="radio" id="mylist" name="tab-name">
        <label class="tab-label" for="mylist">マイリスト</label>
    @endauth

    <div class="items__index">
        <div class="items">
            @foreach($items as $item)
                <div class="item">
                    <a class="item-img" href="{{ route('item.show',$item->id) }}">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="商品画像">
                    </a>
                    <a class="item-img__text" href="{{ route('item.show',$item->id) }}">{{ $item->name }}</a>
                    @if($item->purchase)
                        <span class="sold">SOLD</span>
                    @endif
                </div>
            @endforeach
            @if(request()->filled('keywords'))
                @if($items->isEmpty())
                    <h2>検索結果に該当する商品はありません。</h2>
                @endif
            @endif
        </div>
    </div>

    @auth
        <div class="items__mylist">
            <div class="items">
                @forelse($likes as $like)
                    <div class="item">
                        <a class="item-img" href="{{ route('item.show',['id' => $like->id]) }}">
                            <img src="{{ asset('storage/'.$like->image) }}" alt="商品画像">
                        </a>
                        <a class="item-img__text" href="{{ route('item.show',['id' => $like->id]) }}">{{ $like->name }}</a>
                            @if($like->purchase)
                                <span class="sold">SOLD</span>
                            @endif
                    </div>
                @empty
                    @if(request()->filled('keywords'))
                        <h2>検索した商品で「いいね」しているものはありません。</h2>
                    @else
                        <h2>「いいね」している商品はありません。</h2>
                    @endif
                @endforelse
            </div>
        </div>
    @endauth

</div>
@endsection('content')