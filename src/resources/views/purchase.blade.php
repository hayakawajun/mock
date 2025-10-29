@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')

@if(!$profile)
    <div class="alert__danger">
        <div class="alert__content">
            <p class="alert-massage">配送先の住所が未設定です</p>
        </div>
    </div>
@endif

<form class="purchase-form" action="" method="">
    @csrf
    <div class="left-content">
        <div class="item">
            <div class="item-img">
                <img src="{{ asset('storage/'.$item->image) }}" alt="商品画像">
            </div>
            <div class="item-detail">
                <h2>{{ $item->name }}</h2>
                <p class="item-price"><span>&yen; </span>{{ number_format($item->price) }}</p>
            </div>
        </div>
        <div class="payment">
            <h3>支払い方法</h3>
            <div class="payment__select">
                <select class="payment__select-box" name="payment" id="">
                    <option value="">選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード払い">カード払い</option>
                </select>
            </div>
        </div>
        <div class="delivery">
            <div class="delivery-title">
                <h3>配送先</h3>
                <a href="{{ route('address.edit',$item->id) }}">
                    @empty($profile)
                        配送先住所を登録する
                    @else
                        変更する
                    @endempty
                </a>
            </div>
            <div class="delivery-address">
                @empty($profile)
                    <p ><span>配送先住所が設定されていません</span></p>
                @else
                    <p>&#12306;{{ $profile->postal_code }}</p>
                    <p>{{ $profile->address }}
                        @if($profile->building)
                            {{ $profile->building }}
                        @endif
                    </p>
                @endempty
            </div>
        </div>
    </div>

    <div class="right-content">
        <table class="payment-information">
            <tr class="payment-information__detail">
                <td class="payment-information__detail-title">商品代金</td>
                <td><span>&yen; </span>{{ number_format($item->price) }}</td>
            </tr>
            <tr class="payment-information__detail">
                <td class="payment-information__detail-title">支払い方法</td>
                <td>コンビニ払い</td>
            </tr>
        </table>
        @empty($profile)
            <div class="attention">配送先の住所を登録してください</div>
        @else
            <button class="purchase__btn" type="submit">購入する</button>
        @endempty
    </div>

</form>

@endsection('content')