@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/represent/index.css') }}" />
@endsection

@section('content')
@if ($errors->all())
<div class="represent__alert">
  <div class="represent__alert--danger">
    @error('shop_id')
      {{ $message }} <br>
    @enderror
  </div>
</div>
@endif

<div class="represent__content">
  <div class="section__title">
    <h2>Represent</h2>
  </div>
  <!-- 削除予定 -->
  <!-- <form class="search-form" action="/search" method="get">
    @csrf
    <div class="search-form__item">
      <input class="search-form__item-keyword" type="text" name="keyword"
        value="{{ old('keyword') }}" placeholder="店舗名を入力してください"/>
    </div>
    <div class="search-form__button">
      <button class="search-form__button-submit" type="submit">検索</button>
    </div>
  </form> -->
  <div class="represent-table">
    <div class="represent-table__pagination">
      {{ $shops->links() }}
    </div>
    <table class="represent-table__inner">
      <tr class="represent-table__row">
        <th class="represent-table__header">
          <span class="represent-table__header-span">店舗名</span>
        </th>
        <th class="represent-table__header">
          <span class="represent-table__header-span">地域</span>
        </th>
        <th class="represent-table__header">
          <span class="represent-table__header-span">ジャンル</span>
        </th>
        <th class="represent-table__header">
          <span></span>
        </th>
      </tr>

      @foreach ($shops as $shop)
      <tr class="represent-table__row">
        <td class="represent-table__item">
          <p class="represent-form__itme-p">{{ $shop['name'] }}</p>
        </td>
        <td class="represent-table__item">
          <p class="represent-form__itme-p">{{ $shop->region['name'] ?? '' }}</p>
        </td>
        <td class="represent-table__item">
          <p class="represent-form__itme-p">{{ $shop->genre['name'] ?? '' }}</p>
        </td>
        <td class="represent-table__item">
          <div class="form__button">
            <form class="update-form" action="/represent/update" method="get">
              @csrf
              <div class="update-form__button">
                <button class="update-form__button-submit" >変更</button>
              </div>
              <input type="hidden" name="id" value="{{ $shop['id'] }}">
            </form>
            <form class="reserve-form" action="/represent/reserve" method="get">
              @csrf
              <div class="reserve-form__button">
                <button class="reserve-form__button-submit" >予約確認</button>
              </div>
              <input type="hidden" name="id" value="{{ $shop['id'] }}">
            </form>
          </div>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection