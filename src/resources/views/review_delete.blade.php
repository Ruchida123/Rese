@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/review_delete.css') }}">
@endsection

@section('content')
<div class="review-form">
  <div class="review-form__heading">
    <h3  class="review-form__title">{{ $shop['name'] }}</h3>
  </div>
  <div class="review-form__content">
    <form class="form" action="/review" method="post">
      @method('DELETE')
      @csrf
      <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
      <div class="form__group">
        <div class="form__group-content">
          <h4>評価</h4>
          <div class="stars">
            @for ($i = $review['evaluate']; $i > 0; $i--)
              <span class="star-span">&#x2B50;</span>
            @endfor
            <input type="hidden" name="evaluate" value="{{ $review['evaluate'] }}">
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-content">
          <h4>コメント</h4>
          <span>{{ $review['comment'] }}</span>
        </div>
      </div>
      <div class="form__button">
        <a href="/detail/{{ $shop['id'] }}">戻る</a>
        <button class="form__button-submit" type="submit">
            口コミを削除
        </button>
      </div>
    </form>
  </div>
</div>
@endsection