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

    <input class="index__tab-button" type="radio" id= "index" name="tab-name" checked>
    <label class="tab-label left" for="index">出品した商品</label>
    <input class="mylist__tab-button" type="radio" id="mylist" name="tab-name">
    <label class="tab-label" for="mylist">購入した商品</label>

    <div class="items__index">
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

    <div class="items__mylist">
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