@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/represent/index.css') }}" />
@endsection

@section('content')
@if ($errors->any())
<div class="represent__alert">
  <div class="represent__alert--danger">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </div>
</div>
@elseif(session('error'))
<div class="represent__alert">
  <div class="represent__alert--danger">
    {{ session('error') }}
  </div>
</div>
@endif

<div class="represent__content">
  <div class="section__title">
    <h2>Represent</h2>
  </div>

  <div class="represent-table">
    @hasrole('admin')
      <form class="import-form" action="/import" method="post" enctype="multipart/form-data">
        @csrf
        <div class="import-form__button">
          <button class="import-form__button-submit" type="submit">CSVインポート</button>
        </div>
        <div class="import-form__item">
          <input class="import-form__item-file" type="file" id="csvFile" name="csvFile" accept="text/csv"/>
        </div>
      </form>
      <form action="/export" method="post">
        @csrf
        <div class="export">
          <button class="export__button" type="submit">様式ダウンロード</button>
        </div>
      </form>
    @endhasrole
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
          <p class="represent-form__item-p">{{ $shop['name'] }}</p>
        </td>
        <td class="represent-table__item">
          <p class="represent-form__item-p">{{ $shop->region['name'] ?? '' }}</p>
        </td>
        <td class="represent-table__item">
          <p class="represent-form__item-p">{{ $shop->genre['name'] ?? '' }}</p>
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
            <form class="review-form" action="/allReview/{{ $shop['id'] }}" method="get">
              @csrf
              <div class="review-form__button">
                <button class="review-form__button-submit" >口コミ情報</button>
              </div>
            </form>
          </div>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection