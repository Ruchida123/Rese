@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
@php
  $prev_url = "/mypage";

  if ($prev_id == 2) {
    $prev_url = "/detail/" . $shop['id'];
  };
@endphp
<div class="review">
  <div class="review-detail">
    <p class="review-detail__title">今回のご利用はいかがでしたか？</p>
    <div class="review-detail__content">
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
          @if (isset($favorite))
            <img class="favorite-img liked" src="{{ asset('storage/heart_icon.png') }}" data-shop_id="{{ $shop['id'] }}">
          @else
            <img class="favorite-img" src="{{ asset('storage/heart_icon.png') }}" data-shop_id="{{ $shop['id'] }}">
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="review-form">
    <form class="form" action="/review" method="post" enctype="multipart/form-data">
        @csrf
      <div class="review-form__content">
        <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
        <div class="form__group">
          <div class="form__error">
            @error('evaluate')
            {{ $message }}
            @enderror
          </div>
          <div class="form__group-content">
            <h4>体験を評価してください</h4>
            <div class="form-rating">
              @if (isset($review))
                <!-- 口コミ投稿済 -->
                @for ($i = 5; $i > 0; $i--)
                  @if ($i == $review['evaluate'])
                    <input class="form-rating__input" id="star{{ $i }}" name="evaluate" type="radio" value="{{ $i }}" checked>
                    <label class="form-rating__label" for="star{{ $i }}"><i class="fa-solid fa-star"></i></label>
                  @else
                    <input class="form-rating__input" id="star{{ $i }}" name="evaluate" type="radio" value="{{ $i }}">
                    <label class="form-rating__label" for="star{{ $i }}"><i class="fa-solid fa-star"></i></label>
                  @endif
                @endfor
              @else
                <!-- 口コミ未投稿 -->
                @for ($i = 5; $i > 0; $i--)
                  <input class="form-rating__input" id="star{{ $i }}" name="evaluate" type="radio" value="{{ $i }}">
                  <label class="form-rating__label" for="star{{ $i }}"><i class="fa-solid fa-star"></i></label>
                @endfor
              @endif
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__error">
            @error('comment')
            {{ $message }}
            @enderror
          </div>
          <div class="form__group-content">
            <h4>口コミを投稿</h4>
            @if (isset($review))
              <textarea class="comment" name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット" maxlength="400">{{ $review['comment'] }}</textarea>
            @else
              <textarea class="comment" name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット" maxlength="400"></textarea>
            @endif
            <p id="commentCnt" class="comment-cnt">0/400（最高文字数）</p>
          </div>
        </div>
        <div class="form__group">
          <div class="form__error">
            @error('image')
            {{ $message }}
            @enderror
          </div>
          <div class="form__group-content">
            <h4>画像の追加(最大5MB)</h4>
            <div class="drop-area">
              <label>
                  <p >クリックして画像を追加<br>またはドラッグアンドドロップ</p>
                  <input type="file" name="image" accept="image/jpeg, image/png" class="uploader">
                  @if (isset($review))
                    <div class="preview-area">
                      @if (isset($review->image_url))
                        <img src="{{ asset($review->image_url) }}" alt="No Image">
                      @endif
                    </div>
                  @else
                    <div class="preview-area"></div>
                  @endif
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="form__button">
        <button class="form__button-submit button-margin" type="submit">
          @if (isset($review))
            口コミを更新
          @else
            口コミを投稿
          @endif
        </button>
        <a class="back" href="{{ $prev_url }}">戻る</a>
      </div>
      <input type="hidden" name="prev_id" value="{{ $prev_id }}"/>
    </form>
  </div>
</div>
<script src="{{ asset('js/review.js') }}"></script>
<script src="{{ asset('js/favorite.js') }}"></script>
@endsection