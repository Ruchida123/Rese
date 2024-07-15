@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/thanks.css') }}">
@endsection

@section('content')
<div class="thanks">
  <div class="thanks-message">
    <span class="thanks-message-text">会員登録ありがとうございます</span>
  </div>
  <form class="thanks-form" action="/login" method="get">
    @csrf
    <div class="thanks-form__button">
      <button class="thanks-form__button-submit" type="submit">ログインする</button>
    </div>
  </form>
</div>
@endsection