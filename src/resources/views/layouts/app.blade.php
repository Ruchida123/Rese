<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <div class="openbtn"><span></span><span></span><span></span>
        </div>
        <nav id="g-nav">
          <div id="g-nav-list">
            <ul>
            @if (Auth::check())
              @hasrole('admin')
              <li><a href="/admin">Home</a></li>
              <li><a href="/admin/register">Registration</a></li>
              <li><a href="/represent">ShopList</a></li>
              @endhasrole
              @hasrole('represent')
              <li><a href="/represent">Home</a></li>
              <li><a href="/represent/register">Registration</a></li>
              @endhasrole
              @hasrole('user')
              <li><a href="/">Home</a></li>
              <li><a href="/mypage">Mypage</a></li>
              @endhasrole
              <form name="logout-form" action="/logout" method="post">
                @csrf
                <li><a onclick="document.forms[0].submit();">Logout</a></li>
              </form>
            @else
              <li><a href="/">Home</a></li>
              <li><a href="/register">Registration</a></li>
              <li><a href="/login">Login</a></li>
            @endif
            </ul>
          </div>
        </nav>
        <span class="header__logo">
          Rese
        </span>
      </div>
    </div>
  </header>

  <main class="main">
    @yield('content')
  </main>

  <script src="{{ asset('js/menu.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>