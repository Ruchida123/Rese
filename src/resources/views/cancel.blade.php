@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done">
  <div class="done-message">
    <span class="done-message-text">決済がキャンセルされました</span>
  </div>
  <form class="done-form" action="/mypage" method="get">
    @csrf
    <div class="done-form__button">
      <button class="done-form__button-submit" type="submit">戻る</button>
    </div>
  </form>
</div>
@endsection