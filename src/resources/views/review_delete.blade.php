@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/review_delete.css') }}">
@endsection

@section('content')
@php
  $prev_url = "/";

  if ($prev_id == 2) {
    $prev_url = "/detail/" . $shop['id'];
  } else if ($prev_id == 3) {
    $prev_url = "/allReview/" . $shop['id'];
  };
@endphp

@if ($errors->any())
<div class="detail__alert">
  <div class="detail__alert--danger">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </div>
</div>
@endif

<div class="review-form">
  <div class="review-form__heading">
    <h3  class="review-form__title">{{ $shop['name'] }}</h3>
  </div>
  <div class="review-form__content">
    <form class="form" action="/review" method="post">
      @method('DELETE')
      @csrf
      <div class="form__group">
        <div class="form__group-content">
          <h4>評価</h4>
          <div class="stars">
            @for ($i = $review['evaluate']; $i > 0; $i--)
              <span class="star-span">&#x2B50;</span>
            @endfor
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
        <a href="{{ $prev_url }}">戻る</a>
        <button class="form__button-submit" type="submit">
            口コミを削除
        </button>
      </div>
      <input type="hidden" name="shop" value="{{ $shop['id'] }}">
      <input type="hidden" name="review" value="{{ $review['id'] }}">
      <input type="hidden" name="prev_url" value="{{ $prev_url }}">
    </form>
  </div>
</div>
@endsection