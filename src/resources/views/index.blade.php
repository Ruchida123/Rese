@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal/favorite_error.css') }}">
@endsection

@section('content')
<form class="search-form" action="/search" method="get">
  @csrf
  <div class="search-form__item">
    <select class="search-form__item-region" name="region">
      <option value="">All area</option>
      @foreach ($regions as $region)
      <option value="{{ $region['id'] }}">{{ $region['name'] }}</option>
      @endforeach
    </select>
    <select class="search-form__item-genre" name="genre">
      <option value="">All genre</option>
      @foreach ($genres as $genre)
      <option value="{{ $genre['id'] }}">{{ $genre['name'] }}</option>
      @endforeach
    </select>
    <input class="search-form__item-keyword" type="search" name="keyword"
      value="{{ old('keyword') }}" placeholder="&#x1f50d; Search..."/>
  </div>
</form>

<div class="shop">
  @foreach ($shops as $shop)
  @php
    $favoriteFlag = false;

    if (isset($favorites)) {
      foreach ($favorites as $favorite) {
        if ($favorite['shop_id'] == $shop['id']) {
          $favoriteFlag = true;
        };
      };
    };
  @endphp
  <div class="shop-content">
    <img src="{{ $shop['image_url'] }}" alt="image" />
    <div class="shop-content__name">
      {{ $shop['name'] }}
    </div>
    <div class="shop-content__tag">
      #{{ $shop->region['name'] }} #{{ $shop->genre['name'] }}
    </div>
    <div class="shop-content__detail">
      <form class="detail-form" action="/detail/{{ $shop['id'] }}" method="get">
        @csrf
        <button class="detail-button" type="submit">詳しくみる</button>
      </form>
      @if ($favoriteFlag)
        <img class="favorite-img liked" src="{{ asset('storage/heart_icon.png') }}" data-shop_id="{{ $shop['id'] }}">
      @else
        <img class="favorite-img" src="{{ asset('storage/heart_icon.png') }}" data-shop_id="{{ $shop['id'] }}">
      @endif
    </div>
  </div>
  @endforeach
</div>
<!-- お気に入り登録エラーモーダル -->
@include('modal.favorite_error')
<script src="{{ asset('js/favorite.js') }}"></script>
@endsection