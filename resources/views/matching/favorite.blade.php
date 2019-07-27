@extends('layouts.matching')

@section('title', 'お気に入り登録リスト')

@section('header')
  @include('shared.logout_button')
  <h1 id="title-font" class="text-warning display-3 pt-2 mt-2 mb-5">お気に入り登録リスト</h1>
@endsection

@section('body')
  <!-- お気に入り登録解除メッセージ -->
  @include('shared.flash_message', ['message' => 'favorite_delete'])
  
  <div class="row">
    @foreach($favorites as $favorite)
    <div class="col col-md-6 border border-primary rounded-top" style="background-color: ivory;">
      <!-- プロフィール画像・芸人テーブル・メッセージ送信 -->
      @include('shared.geinin_table', ['geinin' => $favorite->geininFavoriteTo])
      <!-- お気に入り解除ボタン -->
      <div class="mb-5">
        <form action="{{ url('/favorite') }}" method="post">
          {{ csrf_field() }}
          @method('delete')
          <input type="hidden" name="favoriteTo_id" value="{{ $favorite->geininFavoriteTo->id  }}">
          <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人解除">
        </form>
      </div>
    </div>
    @if($loop->iteration % 2 == 0)
  </div>
  <div class="row">
    @endif
    @endforeach
  </div>
@endsection