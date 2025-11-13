@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibition.css')}}">
@endsection

@section('content')
<div class="content">

    <form class="form-field" id="item_exhibition" action="{{ route('item.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <h2 class="content__heading">商品の出品</h2>

        <div class="form__group">
            <label class="input-label">商品画像</label>
            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <div class="upload__item-image">
                <div class="preview-container" id="preview-container">
                    <img class="preview-image" id="preview-image" src="" alt="画像プレビュー">
                </div>
                <p class="file-name" id="file-name__display"></p>
                <div class="upload__field">
                    <label class="upload__item-image--btn" for="file-upload">画像を選択する</label>
                    <input class="upload__item-image--input" type="file" name="image" id="file-upload" accept="image/*">
                </div>
            </div>
        </div>

        <h2 class="content__sub-heading">商品の詳細</h2>

        <div class="form__group">
            <label class="input-label">カテゴリー</label>
            @error('category_ids')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <div class="item-categories">
                @foreach($categories as $category)
                    <input class="category-checkbox" type="checkbox" id="{{ $category->name }}" name="category_ids[]" value="{{ $category->id }}"
                    @if(is_array(old('category_ids')) && in_array($category->id, old('category_ids')))
                        checked
                    @endif
                    >
                    <label class="category-label" for="{{ $category->name }}">{{ $category->name }}</label>
                @endforeach
            </div>
        </div>

        <div class="form__group">
            <label class="input-label">商品の状態</label>
            @error('status')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <select class="status__select" name="status">
                <option value="" disabled selected>選択してください</option>
                <option value="1"
                    @if(old('status') == "1")
                            selected
                    @endif
                >良好</option>
                <option value="2"
                    @if(old('status') == "2")
                            selected
                    @endif
                >目立った傷や汚れなし</option>
                <option value="3"
                    @if(old('status') == "3")
                            selected
                    @endif
                >やや傷や汚れあり</option>
                <option value="4"
                    @if(old('status') == "4")
                            selected
                    @endif
                >状態が悪い</option>
            </select>
        </div>

        <h2 class="content__sub-heading">商品名と説明</h2>

        <div class="form__group">
            <label class="input-label" for="name">商品名</label>
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="name" id="name" value="{{ old('name') }}">
        </div>

        <div class="form__group">
            <label class="input-label" for="bland">ブランド名</label>
            @error('bland')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <input class="input-window" type="text" name="bland" id="bland" value="{{ old('bland') }}">
        </div>

        <div class="form__group">
            <label class="input-label" for="item-description">商品の説明</label>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <textarea class="item-description" type="text" name="description" id="item-description"></textarea>
        </div>

        <div class="form__group">
            <label class="input-label" for="price">販売価格</label>
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <div class="yen-mark">
                <span>&yen;</span>
                <input class="input-window price-input" type="text" id="price_display" value="{{ old('price') }}" oninput="formatPrice(this)">
            </div>
        </div>

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="price" id="price_actual">
        <button class="submit-btn">出品する</button>

    </form>
</div>
<script src="{{ asset('js/upload_item.js') }}"></script>
<script src="{{ asset('js/price.js') }}"></script>
@endsection('content')