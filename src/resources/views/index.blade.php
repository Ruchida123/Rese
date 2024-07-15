@extends('layouts.app')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
@if (session('message'))
<div class="shop__alert">
  <div class="shop__alert--success">
    {{ session('message') }}
  </div>
</div>
@elseif(session('error'))
<div class="shop__alert">
  <div class="shop__alert--danger">
    {{ session('error') }}
  </div>
</div>
@endif

<div class="shop__content">
  @foreach ($shops as $shop)
  <div class="shop__panel">
    <img src="{{ $shop['image_url'] }}" alt="image" />
    <div class="shop__name">
      {{ $shop['name'] }}
    </div>
    <div class="shop__tag">
      #{{ $shop->region['name'] }} #{{ $shop->genre['name'] }}
    </div>
    <div class="shop__detail">
      <button class="detail__button">詳しくみる</button>
      &#9825;
    </div>
  </div>
  @endforeach
</div>
@endsection