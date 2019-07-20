@extends('layouts.matching')

@section('title', 'あなたの相性の良い相方')

@section('header')
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
    ログアウト
  </a>
</div>
<h1 id="title-font" class="text-primary display-3 pt-2 mt-2 mb-5">{{ $auth_geinin->user }}さんの相性の良い相方</h1>
@endsection

@section('body')
<!-- 登録済み -->
@if (session('already_register'))
<div class="alert alert-success mt-5">
  {{ session('already_register') }}
</div>
@endif
<!-- メッセージ送信完了 -->
@if (session('message_success'))
<div class="alert alert-success mt-5">
  {{ session('message_success') }}
</div>
@endif
<!-- お気に入り登録完了 -->
@if (session('favorite_success'))
<div class="alert alert-success mt-5">
  {{ session('favorite_success') }}
</div>
@endif
<!-- お気に入り登録解除 -->
@if (session('favorite_delete'))
<div class="alert alert-success mt-5">
  {{ session('favorite_delete') }}
</div>
@endif

@include('shared.show_geinin', ['matching_percent' => '100'])
@include('shared.show_geinin', ['partners' => $eighty_partners, 'matching_percent' => '80'])
@include('shared.show_geinin', ['partners' => $sixty_partners, 'matching_percent' => '60'])

@endsection