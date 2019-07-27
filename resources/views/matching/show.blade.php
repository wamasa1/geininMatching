@extends('layouts.matching')

@section('title', 'あなたの相性の良い相方')

@section('header')
  @include('shared.logout_button')
  <h1 id="title-font" class="text-primary display-3 pt-2 mt-2 mb-5">{{ $auth_geinin->user }}さんの相性の良い相方</h1>
@endsection

@section('body')
  <!-- 登録済みメッセージ -->
  @include('shared.flash_message', ['message' => 'already_register'])
  <!-- メッセージ送信完了メッセージ -->
  @include('shared.flash_message', ['message' => 'message_success'])
  <!-- お気に入り登録完了メッセージ -->
  @include('shared.flash_message', ['message' => 'favorite_success'])
  <!-- お気に入り登録解除メッセージ -->
  @include('shared.flash_message', ['message' => 'favorite_delete'])

  @include('shared.show_geinin', ['matching_percent' => '100'])
  @include('shared.show_geinin', ['partners' => $eighty_partners, 'matching_percent' => '80'])
  @include('shared.show_geinin', ['partners' => $sixty_partners, 'matching_percent' => '60'])

@endsection