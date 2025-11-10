@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibition.css')}}">
@endsection

@section('content')
<div class="content">

    <form class="form-field" action="{{ route('item.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <h2 class="content__heading">商品の出品</h2>

        <div class="form__group">
            <label class="input-label">商品画像</label>
            <div class="upload__item-image">
                <div class="upload__field">
                    <label class="upload__item-image--btn" for="image"></label>
                    <input class="upload__item-image--input" type="file" name="image" id="image">
                </div>
            </div>
        </div>

        <h2 class="content__sub-heading">商品の詳細</h2>

        <div class="form__group">
            <label class="input-label">カテゴリー</label>
            <div class="item-categories">
                @foreach($categories as $category)
                    <input class="category-checkbox" type="checkbox" id="{{ $category->name }}" name="category_ids[]" value="{{ $category->id }}">
                    <label class="category-label" for="{{ $category->name }}">{{ $category->name }}</label>
                @endforeach
            </div>
        </div>

        <div class="form__group">
            <label class="input-label">商品の状態</label>
            <select class="status__select" name="status">
                <option value="">選択してください</option>
                <option value="1">良好</option>
                <option value="2">目立った傷や汚れなし</option>
                <option value="3">やや傷や汚れあり</option>
                <option value="4">状態が悪い</option>
            </select>
            <p class="error-message">
                @error('status')
                {{ $message }}
                @enderror
            </p>
        </div>

        <h2 class="content__sub-heading">商品名と説明</h2>

        <div class="form__group">
            <label class="input-label" for="name">商品名</label>
            <input class="input-window" type="text" name="name" id="name" value="">
            <p class="error-message">
                @error('name')
                {{ $message }}
                @enderror
            </p>
        </div>

        <div class="form__group">
            <label class="input-label" for="bland">ブランド名</label>
            <input class="input-window" type="text" name="bland" id="bland" value="">
            <p class="error-message">
                @error('bland')
                {{ $message }}
                @enderror
            </p>
        </div>

        <div class="form__group">
            <label class="input-label" for="item-description">商品の説明</label>
            <textarea class="item-description" type="text" name="description" id="item-description"></textarea>
            <p class="error-message">
                @error('description')
                {{ $message }}
                @enderror
            </p>
        </div>

        <div class="form__group">
            <label class="input-label" for="price">販売価格</label>
            <div class="yen-mark">
                <span>&yen;</span>
                <input class="input-window price-input" type="text" name="price" id="price" value="{{ old('price') }}" oninput="formatPrice(this)">
            </div>
            <p class="error-message">
                @error('price')
                {{ $message }}
                @enderror
            </p>
        </div>

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button class="submit-btn">出品する</button>

    </form>
</div>
<script src="{{ asset('js/price.js') }}"></script>
@endsection('content')