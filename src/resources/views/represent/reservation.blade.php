@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/represent/reservation.css') }}" />
@endsection

@section('content')
<div class="represent__content">
  <div class="section__title">
    <div class="title-button">
      <a class="title-button__link" href="/represent">
        ＜
      </a>
    </div>
    <h2>{{ $shop['name'] }}</h2>
  </div>
  <div class="represent-table">
    <div class="represent-table__pagination">
      {{ $reservations->links() }}
    </div>
    <table class="represent-table__inner">
      <tr class="represent-table__row">
        <th class="represent-table__header">
          <span class="represent-table__header-span">予約名</span>
        </th>
        <th class="represent-table__header">
          <span class="represent-table__header-span">日付</span>
        </th>
        <th class="represent-table__header">
          <span class="represent-table__header-span">時間</span>
        </th>
        <th class="represent-table__header">
          <span class="represent-table__header-span">人数</span>
        </th>
      </tr>

      @foreach ($reservations as $reservation)
      <tr class="represent-table__row">
        <td class="represent-table__item">
          <p class="represent-form__item-p">{{ $reservation->user['name'] }}</p>
        </td>
        <td class="represent-table__item">
          <p class="represent-form__item-p">{{ $reservation['date'] }}</p>
        </td>
        <td class="represent-table__item">
          <p class="represent-form__item-p">{{ substr($reservation['time'], 0, 5) }}</p>
        </td>
        <td class="represent-table__item">
          <p class="represent-form__item-p">{{ $reservation['number'] }}</p>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection