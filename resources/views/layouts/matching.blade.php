<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
    <div id="app" class="container text-center mb-5">
      <nav class="navbar navbar-expand navbar-dark fixed-top">
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active bg-secondary" href="{{ url('/search') }}">
              自分で検索
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active bg-primary" href="{{ url('/show') }}" >
              相性の良い相方
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active bg-success" href="{{ url('/profile') }}">
              プロフィール
              </a>
            </li>
            <li class="na-item">
              <a class="nav-link active bg-danger" href="{{ url('/messagebox') }}">
              メッセージボックス
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active bg-warning" href="{{ url('/favorite') }}">
              お気に入りリスト
              </a>
            </li>
          </ul>
        </div>
      </nav>

      @yield('header')

      {{-- ログイン完了メッセージ --}}
      @if (session('login'))
      <div class="alert alert-success mt-5">
        {{ session('login') }}
      </div>
      @endif
      
      @yield('body')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
  </body>
</html>
