@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="user">
    <div class="user-profile">
        <div class="user-image">
            @if($profile->user->profile && $profile->user->profile->image)
                <img src="{{ asset('storage/'.$profile->user->profile->image) }}" alt="プロフィール画像">
            @else
                <img src="{{ asset('image/default.png') }}" alt="デフォルトのプロフィール画像">
            @endif
        </div>
        <h2>{{ $profile->user->name }}</h2>

    </div>
    <div class="profile-edit">
        <a class="profile-edit__link" href="{{ route('profile.show') }}">プロフィールを編集</a>
    </div>
</div>

<div class="tabs">

    <input class="exhibition__tab-button" type="radio" id= "exhibition" name="tab-name" checked>
    <label class="tab-label left" for="exhibition">出品した商品</label>
    <input class="purchase__tab-button" type="radio" id="purchase" name="tab-name">
    <label class="tab-label" for="purchase">購入した商品</label>

    <div class="exhibited-items">
        <div class="items">
            @forelse($exhibitedItems as $item)
                <div class="item">
                    <div class="item-img">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="商品画像">
                    </div>
                    <p class="item-img__text">{{ $item->name }}</p>
                    @if($item->purchase)
                        <span class="sold">SOLD</span>
                    @endif
                </div>
            @empty
                <h2>出品した商品はありません。</h2>
            @endforelse
        </div>
    </div>

    <div class="purchased-items">
        <div class="items">
            @forelse($purchasedItems as $item)
                <div class="item">
                    <div class="item-img">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="商品画像">
                    </div>
                    <p class="item-img__text">{{ $item->name }}</p>
                </div>
            @empty
                <h2>購入した商品はありません。</h2>
            @endforelse
        </div>
    </div>

</div>

<a href="/mypage/profile">プロフィール設定画面へ</a>
@endsection('content')