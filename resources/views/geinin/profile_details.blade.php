@extends('layouts.geinin')

@section('title', 'プロフィール詳細')

@section('header')
<h1 id="title-font" class="display-3 pt-2 mt-2 mb-5">プロフィール詳細</h1>
@endsection

@section('body')
  <figure>
    @if ($geinin->image == null)
      <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
    @else
      <img src="{{ Storage::disk('s3')->url('images/' . $geinin->image) }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
    @endif
    <figcaption>プロフィール画像</figcaption>
  </figure>
  <table id="profile-table" class="table table-hover mb-2">
    <thead>
    </thead>
    <tbody>
      <tr>
        <th class="align-middle bg-primary text-white">ユーザー名</th>
        <td>{{ $geinin->user }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white">漫才とコントのどちらがやりたいですか？</th>
        <td>{{ $geinin->genre }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white">ボケとツッコミのどちらを担当したいですか？</th>
        <td>{{ $geinin->role }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white">ネタは作りますか？</th>
        <td>{{ $geinin->creater }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white">目標</th>
        <td>{{ $geinin->target }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-primary text-white">自己紹介</th>
        <td>{{ $geinin->self_introduce }}</td>
      </tr>
    </tbody>
  </table>
  <a class="btn btn-danger mb-2" href="{{ action('MessageController@message', $geinin->id) }}">
    {{ $geinin->user }}さんにメッセージを送る
  </a>
  {{-- お気に入り芸人登録・解除ボタン --}}
  <div class="mb-5">
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
@endsection
