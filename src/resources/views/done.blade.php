@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done">
  <div class="done-message">
    <span class="done-message-text">ご予約ありがとうございます</span>
  </div>
  <form class="done-form" action="/detail/{{ $shop_id }}" method="get">
    @csrf
    <div class="done-form__button">
      <button class="done-form__button-submit" type="submit">戻る</button>
    </div>
  </form>
</div>
@endsection