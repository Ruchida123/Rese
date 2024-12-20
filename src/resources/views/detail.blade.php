@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
@if ($errors->any())
<div class="detail__alert">
  <div class="detail__alert--danger">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </div>
</div>
@endif

<div class="detail">
  <div class="detail-content detail-content__media">
    <div class="detail-content__title">
      <div class="title-button">
        <a class="title-button__link" href="{{ $prev_url }}">
          ＜
        </a>
      </div>
      <span class="title-name">
        {{ $shop['name'] }}
      </span>
    </div>
    <img src="{{ $shop['image_url'] }}" alt="No Image" />
    <div class="detail-content__tag">
      #{{ $shop->region['name'] ?? '' }} #{{ $shop->genre['name'] ?? '' }}
    </div>
    <div class="detail-content__summary">
      {{ $shop['summary'] ?? '' }}
    </div>
    @if (isset($review))
      <form action="/allReview/{{ $shop['id'] }}" method="get">
        @csrf
        <div class="all-reviews">
          <button type="submit">全ての口コミ情報</button>
        </div>
      </form>
      <div class="review">
        <div class="review-links">
          <a href="/review/{{ $shop['id'] }}/2">口コミを編集</a>
          <form class="form" action="/review/delete" method="get">
            @csrf
            <button class="form-button" type="submit">
              口コミを削除
            </button>
            <input type="hidden" name="review" value="{{ $review['id'] }}">
            <input type="hidden" name="prev" value="2">
          </form>
        </div>
        <div class="review-star">
          @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $review['evaluate'])
              <label class="form-rating__label" for="star{{ $i }}"><i class="fa-solid fa-star fa-star-color"></i></label>
            @else
              <label class="form-rating__label" for="star{{ $i }}"><i class="fa-solid fa-star"></i></label>
            @endif
          @endfor
        </div>
        <div class="review-comment">
          <span>{{ $review['comment'] }}</span>
        </div>
        @if (isset($review['image_url']))
          <div class="review-image">
            <img src="{{ asset($review['image_url']) }}" alt="No Image">
          </div>
        @endif
      </div>
    @endif
  </div>
  <form class="reserve-form" action="/reserve" method="post">
    @csrf
    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}"/>
    <div class="detail-reserve detail-reserve__media">
      <span class="reserve__title">予約</span>
      <div class="reserve__date">
        <input id="reserveDate" class="reserve__date-item" type="date" name="date" value="{{ old('date') }}" placeholder="年/月/日"/>
      </div>
      <div class="reserve__time">
        <select class="reserve__time-item" name="time">
          <option value="">予約時間を選択してください</option>
          @foreach ($times as $time)
            @if(old('time') == $time)
              <option value="{{ $time }}" selected>{{ $time }}</option>
            @else
              <option value="{{ $time }}">{{ $time }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="reserve__num">
        <select class="reserve__num-item" name="number">
          <option value="">予約人数を選択してください</option>
          @foreach ($numbers as $number)
            @if(old('number') == $number)
              <option value="{{ $number }}" selected>{{ $number }}人</option>
            @else
              <option value="{{ $number }}">{{ $number }}人</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="reserve__content reserve__content-media">
        <table cellpadding='3'>
          <tr class="reserve__content-shop">
            <th>Shop</th>
            <td>{{ $shop['name'] }}</td>
          </tr>
          <tr class="reserve__content-date">
            <th>Date</th>
            <td>-</td>
          </tr>
          <tr class="reserve__content-time">
            <th>Time</th>
            <td>-</td>
          </tr>
          <tr class="reserve__content-num">
            <th>Number</th>
            <td>-</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="form__button">
      <button class="form__button-submit" type="submit">予約する</button>
      <input type="hidden" name="prev_url" value="{{ $prev_url }}">
    </div>
  </form>
</div>
@if (Auth::check() && !isset($review))
  <div class="review-link">
    <a href="/review/{{ $shop['id'] }}/2">口コミを投稿する</a>
  </div>
@endif
<script src="{{ asset('js/detail.js') }}"></script>
@endsection