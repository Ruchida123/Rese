@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}" />
<link rel="stylesheet" href="{{ asset('css/modal/message.css') }}">
@endsection

@section('content')
<div class="admin__content">
  <div class="section__title">
    <h2>Admin</h2>
  </div>

  <div class="admin-table">
    <form class="represent-form" action="/represent" method="get">
      @csrf
      <div class="represent-form__button">
        <button class="represent-form__button-submit" type="submit">店舗情報
        </button>
      </div>
    </form>
    <div class="admin-table__pagination">
      {{ $users->links() }}
    </div>
    <table class="admin-table__inner">
      <tr class="admin-table__row">
        <th class="admin-table__header">
          <span class="admin-table__header-span">お名前</span>
        </th>
        <th class="admin-table__header">
          <span class="admin-table__header-span">メールアドレス</span>
        </th>
        <th class="admin-table__header">
          <span class="admin-table__header-span">権限</span>
        </th>
        <th class="admin-table__header">
          <span class="admin-table__header-span">お知らせ</span>
        </th>
      </tr>

      @foreach ($users as $user)
      <tr class="admin-table__row">
        <td class="admin-table__item">
          <p class="admin-form__item-p">{{ $user['name'] }}</p>
        </td>
        <td class="admin-table__item">
          <p class="admin-form__item-p">{{ $user['email'] }}</p>
        </td>
        <td class="admin-table__item">
          <p class="admin-form__item-p">
            @if ($user->hasRole('admin'))
              管理者
            @elseif ($user->hasRole('represent'))
              店舗代表者
            @elseif ($user->hasRole('user'))
              利用者
            @else
              @php
                $search = array('[',']');
                $replace = array('','');
              @endphp
              {{ str_replace($search, $replace, $user->getRoleNames()) }}
            @endif
          </p>
        </td>
        <td class="admin-table__item">
          @if ($user->hasRole('user'))
          <div class="mail-form__button">
            <button class="mail-form__button-submit" data-admin_name="{{ Auth::user()->name }}" data-admin_email="{{ Auth::user()->email }}" data-user_name="{{ $user->name }}" data-user_email="{{ $user->email }}">送信</button>
          </div>
          <!-- <form class="mail-form" action="/mail" method="post">
            @csrf
            <input type="hidden" name="admin_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="admin_name" value="{{ Auth::user()->name }}">
            <input type="hidden" name="user_email" value="{{ $user['email'] }}">
            <input type="hidden" name="user_name" value="{{ $user['name'] }}">
          </form> -->
          @endif
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
<!-- モーダル -->
@include('modal.message')
<script src="{{ asset('js/admin.js') }}"></script>
@endsection