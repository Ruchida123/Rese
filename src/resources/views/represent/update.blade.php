@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/represent/update.css') }}">
@endsection

@section('content')
<div class="register-form">
  <div class="register-form__heading">
    <h3  class="register-form__title">ShopUpdate</h3>
  </div>
  <div class="register-form__content">
    <form class="form" action="/represent/update" method="post">
      @csrf
      <div class="form__group">
        <div class="form__group-content">
          <h4>店舗名</h4>
          <div class="form__input--text">
            <input type="text" name="name" value="{{ old('name', $shop['name']) }}" placeholder="ShopName" />
          </div>
        </div>
        <div class="form__error">
          @error('name')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-content">
          <h4>地域</h4>
          <div class="form__select">
            <select class="item-select" name="region_id">
              <option value="">選択してください</option>
              @foreach ($regions as $region)
              @if(old('region', $shop->region['id'] ?? '') == $region['id'])
              <option value = "{{ $region['id'] }}" selected>{{ $region['name'] }}</option>
              @else
              <option value="{{ $region['id'] }}">{{ $region['name'] }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form__error">
          @error('region_id')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-content">
          <h4>ジャンル</h4>
          <div class="form__select">
            <select class="item-select" name="genre_id">
              <option value="">選択してください</option>
              @foreach ($genres as $genre)
              @if(old('genre', $shop->genre['id'] ?? '') == $genre['id'])
              <option value = "{{ $genre['id'] }}" selected>{{ $genre['name'] }}</option>
              @else
              <option value="{{ $genre['id'] }}">{{ $genre['name'] }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form__error">
          @error('genre_id')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-content">
          <h4>概要</h4>
          <div class="form__input--textarea">
            <textarea class="summary" name="summary">{{ $shop['summary'] ?? '' }}</textarea>
          </div>
        </div>
        <div class="form__error">
          @error('summary')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__button">
        <a href="/represent">戻る</a>
        <button class="form__button-submit" type="submit">変更</button>
      </div>
      <input type="hidden" name="id" value="{{ $shop['id'] }}">
    </form>
  </div>
</div>
@endsection