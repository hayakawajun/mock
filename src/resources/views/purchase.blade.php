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
                    <option value="" disabled selected>選択してください</option>
                    <option value="コンビニ払い"
                        @if(old('payment') == "コンビニ払い")
                            selected
                        @endif
                    >コンビニ払い</option>
                    <option value="カード払い"
                        @if(old('payment') == "カード払い")
                            selected
                        @endif
                    >カード払い</option>
                </select>
            </div>
        </div>

        <div class="delivery">
            <div class="delivery-title">
                <h3>配送先</h3>
                @error('address')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            @empty($profile)
                <div class="delivery-address">
                    <div class="profile-announcement">
                        <h4>プロフィール住所が未設定です。
                        </h4>
                        <a class="profile__create" href="{{ route('profile.show') }}">プロフィール住所を登録する</a>
                    </div>
                </div>
            @else
                <div class="delivery-address">
                    <input class="delivery-address__radio-btn" type="radio" id="profile-address" name="address" value="0"
                        @if(old('address') == "0")
                            checked
                        @endif
                    >
                    <div class="delivery-address__text">
                        <label for="profile-address">
                            <p class="delivery-address__postal_code">&#12306;{{ $profile->postal_code }}</p>
                            <p class="delivery-address__address">{{ $profile->address }}
                                @if($profile->building)
                                    {{ $profile->building }}
                                @endif
                            </p>
                        </label>
                    </div>
                    <div class="delivery-address__edit">
                        <p>プロフィール住所</br>
                        を表示しています</p>
                    </div>
                </div>

                @if($shippingAddresses)
                    @foreach($shippingAddresses as $shippingAddress)
                        <div class="delivery-address">
                            <input class="delivery-address__radio-btn" type="radio" id="shipping-address{{ $shippingAddress->id }}" name="address" value="{{ $shippingAddress->id }}"
                                @if(old('address') == $shippingAddress->id)
                                    checked
                                @endif
                            >
                            <div class="delivery-address__text">
                                <label for="shipping-address{{ $shippingAddress->id }}">
                                    <p class="delivery-address__postal_code">&#12306;{{ $shippingAddress->postal_code }}</p>
                                    <p class="delivery-address__address">{{ $shippingAddress->address }}
                                        @if($shippingAddress->building)
                                            {{ $shippingAddress->building }}
                                        @endif
                                    </p>
                                </label>
                            </div>
                            <div class="delivery-address__edit">
                                <a class="address__change" href="{{ route('address.edit',[ 'item' => $item->id, 'shippingAddress' => $shippingAddress->id ]) }}">変更</a>
                                <a class="address__delete" href="#{{ $shippingAddress->id }}">削除</a>
                            </div>

                            <div class="modal" id="{{ $shippingAddress->id }}">
                                <a href="#!" class="modal-overlay"></a>
                                <div class="modal__inner">
                                    <div class="modal__content">
                                        <h3>こちらの配送先住所を削除してもよろしいですか？</h3>
                                        <div class="modal__address">
                                            <p class="delivery-address__postal_code">&#12306;{{ $shippingAddress->postal_code }}</p>
                                            <p class="delivery-address__address">{{ $shippingAddress->address }}
                                                @if($shippingAddress->building)
                                                    </br>{{ $shippingAddress->building }}
                                                @endif
                                            </p>
                                        </div>
                                        <a class="delete-btn" href="{{ route('address.delete',[ 'item' => $item->id, 'shippingAddress' => $shippingAddress->id ]) }}">削除する</a>
                                    </div>
                                    <a href="#" class="modal__close-btn">× close</a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @endif

                <div class="delivery-address__addition">
                    <a class="address__create" href="{{ route('address.create',[ 'item' => $item->id ]) }}">配送先住所を新たに追加</a>
                </div>

            @endempty

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
                <td><span id="payment__display-area">{{ old('payment','未選択')}}</span></td>
            </tr>
        </table>
        <button class="purchase__btn" type="submit">購入する</button>

    </div>

</form>

<script src="{{ asset('js/payment.js') }}"></script>
@endsection('content')