@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review-form">
  <div class="review-form__heading">
    <h3  class="review-form__title">{{ $shop['name'] }}</h3>
  </div>
  <div class="review-form__content">
    <form class="form" action="/review" method="post">
      @csrf
      <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
      <div class="form__group">
        <div class="form__error">
          @error('evaluate')
          {{ $message }}
          @enderror
        </div>
        <div class="form__group-content">
          <h4>評価</h4>
          <div class="stars">
            @if (isset($review))
              @for ($i = $review['evaluate']; $i > 0; $i--)
                <span class="star-span">&#x2B50;</span>
                <input type="hidden" name="evaluate" value="{{ $review['evaluate'] }}">
              @endfor
            @else
              @for ($i = 5; $i > 0; $i--)
              <div class="star">
                <input class="star-radio" type="radio" name="evaluate" value="{{ $i }}" id="select_radio{{ $i }}">
                @for ($j = $i; $j > 0; $j--)
                  <label class="star-label" for="select_radio{{ $i }}">&#x2B50;</label>
                @endfor
              </div>
              @endfor
            @endif
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-content">
          <h4>コメント</h4>
          @if (isset($review))
            <span>{{ $review['comment'] }}</span>
          @else
            <textarea class="comment" name="comment"></textarea>
          @endif
        </div>
      </div>
      <div class="form__button">
        <a href="/mypage">戻る</a>
        <button class="form__button-submit" type="submit">
          @if (isset($review))
            投稿を削除
          @else
            投稿
          @endif
        </button>
      </div>
    </form>
  </div>
</div>
@endsection