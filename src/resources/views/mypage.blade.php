@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal/message.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal/qr_code.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
@endsection

@section('content')
<h2 class="username">{{ $user['name'] }}さん</h2>
<div class="mypage">
  <div class="reserve">
    <h3>予約状況</h3>
    @foreach($reserves as $reserve)
    <div class="reserve__frame">
      <div class="reserve__header">
        <span class="reserve__header-title">
          <i class="fa fa-clock-o i-margin"></i>予約{{ $loop->iteration }}
        </span>
        <form class="delete-form" action="/reserve" method="post">
          @method('DELETE')
          @csrf
          <button class="delete-form__button" type="submit">
            <span class="dli-close-circle"><span></span></span>
          </button>
          <input type="hidden" name="reserve_id" value="{{ $reserve['id'] }}">
        </form>
      </div>
      <div class="reserve__content reserve__content-media">
        <table cellpadding='3'>
          <tr class="reserve__content-shop">
            <th>Shop</th>
            <td>{{ $reserve->shop['name'] }}</td>
          </tr>
          <tr class="reserve__content-date">
            <th>Date</th>
            <td>{{ $reserve['date'] }}</td>
          </tr>
          <tr class="reserve__content-time">
            <th>Time</th>
            <td>{{ substr($reserve['time'], 0, 5) }}</td>
          </tr>
          <tr class="reserve__content-num">
            <th>Number</th>
            <td>{{ $reserve['number'] }}人</td>
          </tr>
        </table>
      </div>
      <div class="qr-code">
        <button class="qr-code__button" type="submit">
          QRコード
        </button>
      </div>
      <div class="update">
        <form class="update-form" action="/update_reserve" method="get">
          @csrf
          <button class="update-form__button" type="submit">
            変更
          </button>
          <input type="hidden" name="reserve_id" value="{{ $reserve['id'] }}">
        </form>
      </div>
      <div class="review display-none">
        <form class="review-form" action="/review/{{ $reserve['shop_id'] }}" method="get">
          @csrf
          <button class="review-form__button" type="submit">
            評価
          </button>
        </form>
      </div>
    </div>
    <!-- QRコード -->
    @include('modal.qr_code')
    @endforeach
  </div>
  <div class="favorite">
    <h3>お気に入り店舗</h3>
    <div class="shop">
      @foreach ($favorites as $favorite)
      <div class="shop-content">
        <img class="shop-img" src="{{ $favorite->shop['image_url'] }}" alt="No Image" />
        <div class="shop-content__name">
          {{ $favorite->shop['name'] }}
        </div>
        <div class="shop-content__tag">
          #{{ $favorite->shop->region['name'] ?? '' }} #{{ $favorite->shop->genre['name'] ?? '' }}
        </div>
        <div class="shop-content__detail">
          <form class="detail-form" action="/detail/{{ $favorite->shop['id'] }}" method="get">
            @csrf
            <button class="detail-button" type="submit">詳しくみる</button>
          </form>
          <img class="favorite-img liked" src="{{ asset('storage/heart_icon.png') }}" data-shop_id="{{ $favorite->shop['id'] }}">
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
<!-- モーダル -->
@include('modal.message')
<script src="{{ asset('js/favorite.js') }}"></script>
<script src="{{ asset('js/mypage.js') }}"></script>
@endsection