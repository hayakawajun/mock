@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')
<form class="purchase-form" action="{{ route('item.payment') }}" method="post">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="item_id" value="{{ $item->id }}">

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
            @error('payment')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <div class="payment__select">
                <select class="payment__select-box" name="payment" id="payment-select">
                    <option value="">選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード払い">カード払い</option>
                </select>
            </div>
        </div>
        <div class="delivery">
            <div class="delivery-title">
                <div>
                    <h3>配送先</h3>
                    @error('address')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <a href="{{ route('address.edit',$item->id) }}">
                    @empty($profile)
                        登録する
                    @else
                        変更する
                    @endempty
                </a>
            </div>
            <div class="delivery-address">
                @empty($profile)
                    <p ><span>未設定</span></p>
                @else
                    <p>&#12306;{{ $profile->postal_code }}</p>
                    <p>{{ $profile->address }}
                        <input type="hidden" name="postal_code" value="{{ $profile->postal_code }}">
                        <input type="hidden" name="address" value="{{ $profile->address }}">
                        @if($profile->building)
                            {{ $profile->building }}
                            <input type="hidden" name="building" value="{{ $profile->building }}">
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
                <td><span id="payment__display-area">未選択</span></td>
            </tr>
        </table>
        <button class="purchase__btn" type="submit">購入する</button>
    </div>

</form>
<script src="{{ asset('js/payment.js') }}"></script>
@endsection('content')