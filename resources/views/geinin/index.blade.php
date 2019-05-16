@extends('layouts.geininapp')

@section('title', '相方マッチングサイト')
@section('header')
 相方マッチングサイト
   <a class="float-right mt-3 btn btn-primary btn-lg" href="{{ url('/login')}}" role="button">
     ログイン
   </a>

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
