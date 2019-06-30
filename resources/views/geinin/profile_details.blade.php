@extends('layouts.geinin')

@section('title', 'プロフィール詳細')

@section('header')
<h1 id="title-font" class="display-3 pt-2 mt-2 mb-5">プロフィール詳細</h1>
@endsection

@section('body')
<div style="background-color: ghostwhite;">
  <figure>
    @if ($geinin->image == null)
      <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
    @else
      <img src="{{ Storage::disk('s3')->url('images/' . $geinin->image) }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
    @endif
    <figcaption>プロフィール画像</figcaption>
  </figure>
  <table id="profile-table" class="table mb-2">
    <thead>
    </thead>
    <tbody>
      <tr>
        <th class="align-middle bg-primary text-white py-3">ユーザー名</th>
        <td class="align-middle">{{ $geinin->user }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white py-3">漫才とコントのどちらがやりたいですか？</th>
        <td class="align-middle">{{ $geinin->genre }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white py-3">ボケとツッコミのどちらを担当したいですか？</th>
        <td class="align-middle">{{ $geinin->role }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white py-3">ネタは作りますか？</th>
        <td class="align-middle">{{ $geinin->creater }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white py-3">目標</th>
        <td class="align-middle">{{ $geinin->target }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white py-3">自己紹介</th>
        <td class="align-middle">{{ $geinin->self_introduce }}</td>
      </tr>
    </tbody>
  </table>
  <a class="btn btn-danger my-3" href="{{ action('MessageController@message', $geinin->id) }}">
    {{ $geinin->user }}さんにメッセージを送る
  </a>
  <!-- お気に入り芸人登録・解除ボタン -->
  <div class="my-2">
    <form action="{{ url('/search') }}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="favoriteTo_id" value="{{ $geinin->id }}">
      @auth('geinin')
        @forelse ($geinin->favoriteTo as $favoriteTo)
          @if ($favoriteTo->favoriteFrom_id == $auth_id)
            @method('delete')
            <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人解除">
          @elseif ($loop->last)
            @method('patch')
            <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人登録">
          @endif
        @empty
          @method('patch')
          <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人登録">
        @endforelse
      @else
        @method('patch')
        <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人登録">
      @endauth
    </form>
  </div>
  </div>
@endsection
