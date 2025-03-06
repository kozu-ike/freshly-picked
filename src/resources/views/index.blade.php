@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
<link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')

</header>
<div class="header_nav">
    <h2 class="product-list-title">商品一覧</h2>
    <div class="register">
        <a href="/products/register">
            +商品を追加
        </a>
    </div>
</div>
<main>
    <div class="search-form">
        <form action="/products/search" method="get">
            <input class="search-form__keyword" type="text" name="keyword" placeholder="商品名で検索" value="{{request('keyword')}}">
            <div class="search-form__actions">
                <input class="search-form__search-btn btn" type="submit" value="検索">
            </div>
        </form>
    </div>
    <div class="sort-options">
        <label for="sort_order" class="sort-label">価格順で表示</label>
        <form action="/products/sort" method="GET">
            <select name="sort_order" id="sort_order" onchange="this.form.submit()">
                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>価格が安い順</option>
                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>価格が高い順</option>
            </select>
        </form>
    </div>


    <div class="sort-tags">
        @if (request('sort_order'))
        <div class="tag">
            {{ request('sort_order') == 'asc' ? '価格が安い順' : '価格が高い順' }}
            <span class="remove-tag" onclick="resetSort()">×</span>
        </div>
        @endif
    </div>
    <div class="product-grid">
        @foreach ($products as $product)
        <div class="product-card">
            <a href="/products/{{ $product->id }}">
                <img src="{{ asset('storage/products/'.$product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>¥{{ number_format($product->price) }}</p>
            </a>
        </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $products->links('pagination.custom', ['paginator' => $products]) }}
    </div>
    @endsection