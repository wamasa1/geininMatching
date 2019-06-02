@extends('layouts.matching')

@section('title', 'お気に入り登録リスト')

@section('header')
  <div class="text-right pt-5 mt-5">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  <h1 class="text-warning display-3 pt-2 mt-2 mb-5">お気に入り登録リスト</h1>
@endsection

@section('body')
  <div class="row">
  @foreach($favorites as $favorite)
    <div class="col">
      <figure>
        @if ($favorite->image == null)
          <img src="{{ asset('/images/noimage.png') }}" class="rounded-circle mt-5" width="150" height="150">
        @else
          <img src="{{ Storage::disk('s3')->url('images/' . $favorite->image) }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
        @endif
        <figcaption>プロフィール画像</figcaption>
      </figure>

      <table id="question" class="table table-hover mb-2">
        <thead>
        </thead>
        <tbody>
          <tr>
            <th class="align-middle bg-primary text-white">ユーザー名</th>
            <td>{{ $favorite->geininFavoriteTo->user }}</td>
          </tr>
          <tr>
            <th class="align-middle bg-primary text-white">漫才とコントのどちらがやりたいですか？</th>
            <td>{{ $favorite->geininFavoriteTo->genre }}</td>
          </tr>
          <tr>
            <th class="align-middle bg-primary text-white">ボケとツッコミのどちらを担当したいですか？</th>
            <td>{{ $favorite->geininFavoriteTo->role }}</td>
          </tr>
          <tr>
            <th class="align-middle bg-primary text-white">ネタは作りますか？</th>
            <td>{{ $favorite->geininFavoriteTo->creater }}</td>
          </tr>
          <tr>
            <th class="align-middle bg-primary text-white">目標</th>
            <td>{{ $favorite->geininFavoriteTo->target }}</td>
          </tr>
          <tr>
            <th class="align-middle bg-primary text-white">自己紹介</th>
            <td>{{ $favorite->geininFavoriteTo->self_introduce }}</td>
          </tr>
        </tbody>
      </table>
      <a class="btn btn-danger mb-2" href="{{ action('MessageController@message', $favorite->geininFavoriteTo->id) }}">
        {{ $favorite->geininFavoriteTo->user }}さんにメッセージを送る
      </a>
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
