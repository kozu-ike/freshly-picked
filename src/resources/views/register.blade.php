@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('content')
<div class="container">
    <h1>商品登録</h1>

    <form action="{{ url('/products') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">商品名 <span class="required">必須</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">値段 <span class="required">必須</span></label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @if ($errors->has('price'))
            @foreach ($errors->get('price') as $error)
            <div class="error">{{ $error }}</div>
            @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="image">商品画像 <span class="required">必須</span></label>
            <input type="file" id="image" name="image" accept="image/*">
            @if ($errors->has('image'))
            @foreach ($errors->get('image') as $error)
            <div class="error">{{ $error }}</div>
            @endforeach
            @endif

            @if (session('image_preview'))
            <div class="image-preview" style="margin-top: 20px;">
                <img src="{{ session('image_preview') }}" alt="プレビュー画像" width="200">
            </div>
            <p>{{ session('image_preview') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="season">季節 <span class="required">必須</span></label>
            <label for="spring">
                @php
                $selectedSeasons = old('season', []);
                @endphp
                <input type="checkbox" name="season[]" id="spring" value="1" {{ in_array(1, (array) $selectedSeasons) ? 'checked' : '' }}> 春
            </label>

            <label for="summer">
                <input type="checkbox" name="season[]" id="summer" value="2" {{ in_array(2, (array) $selectedSeasons) ? 'checked' : '' }}> 夏
            </label>

            <label for="autumn">
                <input type="checkbox" name="season[]" id="autumn" value="3" {{ in_array(3,  (array) $selectedSeasons) ? 'checked' : '' }}> 秋
            </label>

            <label for="winter">
                <input type="checkbox" name="season[]" id="winter" value="4" {{ in_array(4,  (array) $selectedSeasons) ? 'checked' : '' }}> 冬
            </label>

            @if ($errors->has('season'))
            @foreach ($errors->get('season') as $error)
            <div class="error">{{ $error }}</div>
            @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="description">商品説明 <span class="required">必須</span></label>
            <textarea id="description" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @if ($errors->has('description'))
            @foreach ($errors->get('description') as $error)
            <div class="error">{{ $error }}</div>
            @endforeach
            @endif
        </div>

        <!-- ボタンを <form> 内に配置 -->
        <button type="submit" class="btn">登録</button>
    </form>

    <div class="back-button">
        <a href="{{ url('/products') }}" class="btn">戻る</a>
    </div>
</div>
@endsection