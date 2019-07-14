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
  <div class="container text-center mb-5">
    @yield('header')
    @yield('body')
  </div>
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</body>

</html>