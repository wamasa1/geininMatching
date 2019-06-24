@extends('layouts.matching')

@section('title', '相方マッチングサイト')

@section('header')
<!-- 認証時はログアウトボタン それ以外の時はログインボタン -->
@if ($auth)
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
    ログアウト
  </a>
</div>
@else
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/login') }}" role="button">
    ログイン
  </a>
</div>
@endif

<h1 id="title-font" class="display-3 pt-2 mt-2 mb-5">相方マッチングサイト</h1>
@endsection

@section('body')
  <!-- ログアウトメッセージ -->
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
  <!-- ランキング -->
  <div class="mt-5">
    <h3>人気芸人ランキング</h3>
    <div class="table-responsive">
      <table class="table mb-2">
        <thead>
          <tr>
            <td>順位</td>
            <td>プロフィール画像</td>
            <td>名前</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($geinins as $geinin)
          <tr>
            <td class="align-middle">{{ $loop->iteration }}位</td>
            <td>
              @if ($geinin->image == null)
                <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle" width="50" height="50" alt="画像">
              @else
                <img src="{{ Storage::disk('s3')->url('images/' . $geinin->image) }}" class="rounded-circle" width="50" height="50" alt="画像">
              @endif
            </td>
            <td class="align-middle">
              <a href="{{ url('/profile/' . $geinin->id) }}" target="_blank">{{ $geinin->user }}</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <footer class="text-center text-muted mt-5">
    Copyright Masataka Kadogawa
  </footer>
@endsection
