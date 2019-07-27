@extends('layouts.matching')

@section('title', '相方マッチングサイト')

@section('header')
  <!-- 認証時はログアウトボタン それ以外の時はログインボタン -->
  @if ($auth)
    @include('shared.logout_button')
  @else
    @include('shared.login_button')
  @endif

  <h1 id="title-font" class="pt-2 mt-2 mb-5">相方マッチングサイト</h1>
@endsection

@section('body')
  <!-- ログアウトメッセージ -->
  @include('shared.flash_message', ['message' => 'logout'])
  <!-- アカウント削除完了メッセージ -->
  @include('shared.flash_message', ['message' => 'account_delete'])

  <div style="background-color: ghostwhite;">
    <!-- スライド写真 -->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="{{ asset('/images/shaking-hands.jpg') }}" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{ asset('/images/dogManzai.jpg') }}" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{ asset('/images/seal.jpg') }}" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <p class="text-center font-weight-bold mt-5">
      漫才がしたい！ コントがしたい！ だけど、相方がいないそんなあなたへ
    </p>
    <div class="row">
      <div class="col">
        <a class="my-3 py-4 btn btn-outline-primary" href="{{ url('/register') }}" role="button">
          登録して理想の相方とマッチング
        </a>
      </div>
      <div class="col">
        <a class="my-3 py-4 btn btn-outline-secondary" href="{{ url('/search') }}" role="button">
          登録せず自分で検索する
        </a>
      </div>
    </div>
  </div>
  <!-- ランキング -->
  <div class="mt-5" style="background-color: ghostwhite;">
    <h3>人気芸人ランキング</h3>
    <div class="table-responsive">
      <table class="table mb-2">
        <thead>
          <tr>
            <td class="align-middle text-nowrap">順位</td>
            <td class="align-middle text-nowrap">プロフィール画像</td>
            <td>名前</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($geinins as $geinin)
            <tr>
              <td class="align-middle text-nowrap">{{ $loop->iteration }}位</td>
              <td>
                @if ($geinin->image == null)
                  <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle" width="50" height="50" alt="画像">
                @else
                  <img src="{{ Storage::disk('s3')->url('images/' . $geinin->image) }}" class="rounded-circle" width="50" height="50" alt="画像">
                @endif
              </td>
              <td class="align-middle text-nowrap">
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