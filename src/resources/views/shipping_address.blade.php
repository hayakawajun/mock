@extends('layouts.app')

@section('content')
<div class="content">

    <form class="register-form form-field" action="{{ route('address.update',$item->id) }}" method="post" >
        @csrf
        @empty($shippingAddress)
            <h2 class="content__heading">配送先住所の登録</h2>
        @else
            <h2 class="content__heading">配送先住所の変更</h2>
        @endempty

        <div class="form__group">
            <label class="input-label" for="postal_code">郵便番号</label>
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code',$shippingAddress->postal_code ?? '') }}">
        </div>

        <div class="form__group">
            <label class="input-label" for="address">住所</label>
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="address" id="address" value="{{ old('address',$shippingAddress->address ?? '') }}">
        </div>

        <div class="form__group">
            <label class="input-label" for="building">建物名</label>
            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="building" id="building" value="{{ old('building',$shippingAddress->building ?? '') }}">
        </div>

        <button class="submit-btn">
            @empty($shippingAddress)
                登録する</button>
            <input type="hidden" name="id" value="">
            @else
                更新する</button>
            <input type="hidden" name="id" value="{{ $shippingAddress->id }}">
            @endempty

    </form>

</div>
@endsection('content')