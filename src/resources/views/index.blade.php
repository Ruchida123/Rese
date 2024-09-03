@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal/message.css') }}">
@endsection

@section('content')
<div class="search">
  <div class="search-item">
    <select class="search-item__region region-width" name="region">
      <option value="">All area</option>
      @foreach ($regions as $region)
      <option value="{{ $region['id'] }}">{{ $region['name'] }}</option>
      @endforeach
    </select>
    <select class="search-item__genre genre-width" name="genre">
      <option value="">All genre</option>
      @foreach ($genres as $genre)
      <option value="{{ $genre['id'] }}">{{ $genre['name'] }}</option>
      @endforeach
    </select>
    <input class="search-item__keyword keyword-width" type="search" name="keyword"
      value="{{ old('keyword') }}" placeholder="&#x1f50d; Search..."/>
  </div>
</div>

<div class="shop shop-gap">
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
    <img class="shop-img" src="{{ $shop['image_url'] }}" alt="No Image" />
    <div class="shop-content__name">
      {{ $shop['name'] }}
    </div>
    <div class="shop-content__tag">
      #{{ $shop->region['name'] ?? '' }} #{{ $shop->genre['name'] ?? '' }}
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
@include('modal.message')
<script src="{{ asset('js/favorite.js') }}"></script>
@endsection