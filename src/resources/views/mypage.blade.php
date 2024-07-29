@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal/favorite_error.css') }}">
@endsection

@section('content')
<div class="mypage">
  <div class="reserve">
    @foreach($reserves as $reserve)
    <div class="reserve__frame">
      <div class="reserve__header">
        <span class="reserve__header-title">予約</span>
        <form class="delete-form" action="/reserve" method="post">
          @method('DELETE')
          @csrf
          <button class="delete-form__button" type="submit">×</button>
          <input type="hidden" name="reserve_id" value="{{ $reserve['id'] }}">
        </form>
      </div>
      <div class="reserve__content">
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
    </div>
    @endforeach
  </div>
  <div class="shop">
    @foreach ($favorites as $favorite)
    <div class="shop-content">
      <img src="{{ $favorite->shop['image_url'] }}" alt="image" />
      <div class="shop-content__name">
        {{ $favorite->shop['name'] }}
      </div>
      <div class="shop-content__tag">
        #{{ $favorite->shop->region['name'] }} #{{ $favorite->shop->genre['name'] }}
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
<!-- モーダル -->
@include('modal.favorite_error')
<script src="{{ asset('js/favorite.js') }}"></script>
@endsection