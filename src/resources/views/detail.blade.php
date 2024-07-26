@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
@if ($errors->all())
<div class="detail__alert">
  <div class="detail__alert--danger">
    @error('auth')
      {{ $message }} <br>
    @enderror
    @error('shop_id')
      {{ $message }} <br>
    @enderror
    @error('date')
      {{ $message }} <br>
    @enderror
    @error('time')
      {{ $message }} <br>
    @enderror
    @error('number')
      {{ $message }} <br>
    @enderror
  </div>
</div>
@endif

<div class="detail">
  <div class="detail-content">
    <div class="detail-content__title">
      <form class="title-form" action="/" method="get">
        @csrf
        <button class="title-form__button" type="submit">＜</button>
      </form>
      <span class="title-name">
        {{ $shop['name'] }}
      </span>
    </div>
    <img src="{{ $shop['image_url'] }}" alt="image" />
    <div class="detail-content__tag">
      #{{ $shop->region['name'] }} #{{ $shop->genre['name'] }}
    </div>
    <div class="detail-content__summary">
      {{ $shop['summary'] }}
    </div>
  </div>
  <form class="reserve-form" action="/reserve" method="post">
    @csrf
    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}"/>
    <div class="detail-reserve">
      <span class="reserve__title">予約</span>
      <div class="reserve__date">
        <input class="reserve__date-item" type="date" name="date" value="{{ old('date') }}" placeholder="年/月/日"/>
      </div>
      <div class="reserve__time">
        <select class="reserve__time-item" name="time">
          <option value="">予約時間を選択してください</option>
          @foreach ($times as $time)
          <option value="{{ $time }}">{{ $time }}</option>
          @endforeach
        </select>
      </div>
      <div class="reserve__num">
        <select class="reserve__num-item" name="number">
          <option value="">予約人数を選択してください</option>
          @foreach ($numbers as $number)
          <option value="{{ $number }}">{{ $number }}人</option>
          @endforeach
        </select>
      </div>
      <div class="reserve__content">
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
    </div>
  </form>
</div>
<script src="{{ asset('js/detail.js') }}"></script>
@endsection