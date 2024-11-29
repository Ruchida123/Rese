@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/review_all.css') }}" />
@endsection

@section('content')
<div class="review__content">
  <div class="section__title">
    <h2>{{ $shop['name'] }}</h2>
    <h2>口コミ情報 {{ count($reviews) }}件</h2>
  </div>

  <div class="review-table">
    <div class="review-table__pagination">
      {{ $reviews->links() }}
    </div>

    @foreach ($reviews as $review)
      <div class="review">
        <div class="review-links">
          @hasrole('admin')
            <form class="form" action="/review/delete" method="get">
              @csrf
              <button class="form-button" type="submit">
                口コミを削除
              </button>
              <input type="hidden" name="review" value="{{ $review['id'] }}">
              <input type="hidden" name="prev" value="3">
            </form>
          @endhasrole
          @hasrole('user')
            @if ($review['user_id'] == $user_id)
              <a href="/review/{{ $shop['id'] }}/2">口コミを編集</a>
              <form class="form" action="/review/delete" method="get">
                @csrf
                <button class="form-button" type="submit">
                  口コミを削除
                </button>
                <input type="hidden" name="review" value="{{ $review['id'] }}">
                <input type="hidden" name="prev" value="3">
              </form>
            @endif
          @endhasrole
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
    @endforeach
  </div>
</div>
@endsection