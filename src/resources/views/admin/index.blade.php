@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}" />
@endsection

@section('content')
<div class="admin__content">
  <div class="section__title">
    <h2>Admin</h2>
  </div>
  <!-- 削除予定 -->
  <!-- <form class="search-form" action="/search" method="get">
    @csrf
    <div class="search-form__item">
      <input class="search-form__item-keyword" type="text" name="keyword"
        value="{{ old('keyword') }}" placeholder="名前やメールアドレスを入力してください"/>
    </div>
    <div class="search-form__button">
      <button class="search-form__button-submit" type="submit">検索</button>
    </div>
  </form> -->
  <div class="admin-table">
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
          <span></span>
        </th>
      </tr>

      @foreach ($users as $user)
      <tr class="admin-table__row">
        <td class="admin-table__item">
          <p class="admin-form__itme-p">{{ $user['name'] }}</p>
        </td>
        <td class="admin-table__item">
          <p class="admin-form__itme-p">{{ $user['email'] }}</p>
        </td>
        <td class="admin-table__item">
          <p class="admin-form__itme-p">
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
              <button class="mail-form__button-submit" >送信</button>
            </div>
          @endif
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection