@extends('layouts.geinin')

@section('title', '相方マッチングサイト')

@section('header')
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/login') }}" role="button">
    ログイン
  </a>
</div>
<h1 class="display-3 pt-2 mt-2 mb-5">相方マッチングサイト</h1>
@endsection

@section('body')
  @if (session('logout'))
  <div class="alert alert-success">
    {{ session('logout') }}
  </div>
  @endif

  <img src="{{ asset('/images/shaking-hands.jpg') }}" class="col rounded-circle mt-3">
  <p class="text-center font-weight-bold mt-5">
    漫才がしたい！ コントがしたい！ だけど、相方がいないそんなあなたへ
  </p>
  <div class="row">
    <div class="col">
      <a class="my-3 py-4 btn btn-primary btn-lg" href="{{ url('/register') }}" role="button">
        登録して理想の相方とマッチング
      </a>
    </div>
    <div class="col">
      <a class="my-3 py-4 btn btn-primary btn-lg" href="{{ url('/search') }}" role="button">
        登録せず自分で検索する
      </a>
    </div>
  </div>
  <footer class="text-center text-muted mt-5">
    Copyright Masataka Kadogawa
  </footer>
@endsection
