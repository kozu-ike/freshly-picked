@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="container_title">
        商品一覧 > <span class="container_fruit_name">{{ old('name', $product->name) }}</span>
    </div>

    <div class="product-show">
        <form action="{{ url('/products/'.$product->id.'/update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="product-main">
                <div class="product-info">
                    <div class="form-group_fruit_img">
                        <img src="{{ asset('storage/products/'.$product->image) }}" alt="商品画像">
                        <br>
                        <input type="file" class="form-group_new_img" id="image" name="image" accept=".png, .jpeg">
                        @error('image')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error" id="image-error">
                        @if (empty(old('image', $product->image)))
                        選択されていません
                        @endif
                    </div>
                </div>

                <div class="product-info">
                    <div class="product-info_change">
                        <div class="form-group_fruit_name">
                            <label for="name">商品名</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
                            @error('name')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group_fruit_price">
                            <label for="price">値段</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}">
                            @error('price')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group_fruit_season">
                            <label>季節</label>
                            <div class="season-checkboxes">
                                @php
                                $selectedSeasons = old('season', $product->seasons->pluck('id')->toArray());
                                @endphp
                                <label for="spring">
                                    <input type="checkbox" name="season[]" id="spring" value="1"
                                        {{ in_array(1, (array) $selectedSeasons) ? 'checked' : '' }}> 春
                                </label>

                                <label for="summer">
                                    <input type="checkbox" name="season[]" id="summer" value="2"
                                        {{ in_array(2, (array)  $selectedSeasons) ? 'checked' : '' }}> 夏
                                </label>

                                <label for="autumn">
                                    <input type="checkbox" name="season[]" id="autumn" value="3"
                                        {{ in_array(3, (array)  $selectedSeasons) ? 'checked' : '' }}> 秋
                                </label>

                                <label for="winter">
                                    <input type="checkbox" name="season[]" id="winter" value="4"
                                        {{ in_array(4, (array) $selectedSeasons) ? 'checked' : '' }}> 冬
                                </label>

                                @if ($errors->has('season'))
                                @foreach ($errors->get('season') as $error)
                                <div class="error">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group_fruit_content">
                <label for="description">商品説明</label>
                <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group_buttons">
                <div class="form-group_buttons-left">
                    <a href="{{ url('/products') }}" class="btn back-button">戻る</a>
                </div>
                <div class="form-group_buttons-center">
                    <button type="submit" class="btn save-btn">変更を保存</button>
                </div>
                <div class="form-group_buttons-right">
                    <button type="submit" class="delete-btn" form="delete-form">
                        <img src="{{ asset('storage/products/trash.png') }}" alt="削除">
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="/products/{{ $product->id }}/delete" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')

        </form>

    </div>
</div>
@endsection