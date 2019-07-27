@extends('layouts.matching')

@section('title', 'あしあと')

@section('header')
   <!-- 認証時はログアウトボタン それ以外の時はログインボタン -->
  @if ($auth)
    @include('shared.logout_button')
  @else
    @include('shared.login_button')
  @endif

   <h1 id="title-font" class="pt-2 mt-2 mb-3" style="color: darkorange;">閲覧履歴</h1>
@endsection

@section('body')
  <!-- お気に入り登録完了メッセージ -->
  @include('shared.flash_message', ['message' => 'favorite_success'])
  <!-- お気に入り登録解除メッセージ -->
  @include('shared.flash_message', ['message' => 'favorite_delete'])
  
  <h4>最近あなたがプロフィール詳細を閲覧した芸人</h4>
  <div class="row">
    @foreach($histories as $history)
      <div class="col col-md-6 border border-primary rounded-top" style="background-color: peachpuff;">
        <!-- プロフィール画像・芸人テーブル・メッセージ送信 -->
        @include('shared.geinin_table', ['geinin' => $history->seenGeinin])
        <!-- お気に入り芸人登録・解除ボタン -->
        @include('shared.favorite_button', ['geinin' => $history->seenGeinin, 'url' => 'history'])
      </div>
      @if($loop->iteration % 2 == 0)
  </div>
  <div class="row">
      @endif
    @endforeach
  </div>
@endsection