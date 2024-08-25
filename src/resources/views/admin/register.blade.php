@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/admin/register.css') }}">
@endsection

@section('content')
<div class="register-form">
  <div class="register-form__heading">
    <h3  class="register-form__title">AdminRegistration</h3>
  </div>
  <div class="register-form__content">
    <form class="form" action="/admin/register" method="post">
      @csrf
      <div class="form__group">
        <div class="form__group-content role-radio">
          <input type="radio" id="user" name="role" value=1 checked/>
          <label for="user">利用者</label>
          <input type="radio" id="represent" name="role" value=2 />
          <label for="represent">店舗代表者</label>
        </div>
        <div class="form__error">
          @error('role')
            {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-content">
          <img src="{{asset('storage/user_icon.png')}}">
          <div class="form__input--text">
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Username" />
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
        <button class="form__button-submit" type="submit">登録</button>
      </div>
    </form>
  </div>
</div>
@endsection