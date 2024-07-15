@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login-form">
  <div class="login-form__heading">
    <h3 class="login-form__title">Login</h3>
  </div>
  <div class="login-form__content">
    <form class="form" action="/login" method="post">
      @csrf
      <div class="form__group">
        <div class="form__group-content">
          <img src="{{asset('storage/mail_icon.png')}}">
          <div class="form__input--text">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
          </div>
        </div>
        <div class="form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-content">
          <img src="{{asset('storage/pass_icon.png')}}">
          <div class="form__input--text">
            <input type="password" name="password" placeholder="Password" />
          </div>
        </div>
        <div class="form__error">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__button">
        <button class="form__button-submit" type="submit">ログイン</button>
      </div>
    </form>
  </div>
</div>
@endsection