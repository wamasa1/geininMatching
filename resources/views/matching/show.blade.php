@extends('layouts.matching')

@section('title', 'あなたの相性の良い相方')

@section('header')
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
    ログアウト
  </a>
</div>
<h1 id="title-font" class="text-primary display-3 pt-2 mt-2 mb-5">{{ $auth_geinin->user }}さんの相性の良い相方</h1>
<h1 id="title-font" class="text-danger pt-2 mt-2 mb-5">マッチング率{{ $matching_percent }}%</h1>
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
<!-- 相性の良い芸人表示 -->
<div class="row">
  @forelse ($partners as $partner)
  <div class="col col-md-6 border border-primary rounded-top" style="background-color: aliceblue;">
    <figure>
      @if ($partner->image == null)
      <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
      @else
      <img src="{{ Storage::disk('s3')->url('images/' . $partner->image) }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
      @endif
      <figcaption>現在のプロフィール画像</figcaption>
    </figure>

    <table id="profile-table" class="table mb-2">
      <thead>
      </thead>
      <tbody>
        <tr>
          <th class="align-middle bg-primary text-white">ユーザー名</th>
          <td class="align-middle"><a href="{{ url('/profile/' . $partner->id) }}" target="_blank">{{ $partner->user }}</a></td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">希望する活動場所</th>
          <td class="align-middle">{{ $partner->activity_place }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">漫才とコントのどちらがやりたいですか？</th>
          <td class="align-middle">{{ $partner->genre }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">ボケとツッコミのどちらを担当したいですか？</th>
          <td class="align-middle">{{ $partner->role }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">ネタは作りますか？</th>
          <td class="align-middle">{{ $partner->creater }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">目標</th>
          <td class="align-middle">{{ $partner->target }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">自己紹介</th>
          <td class="align-middle">{{ $partner->self_introduce }}</td>
        </tr>
      </tbody>
    </table>
    <a class="btn btn-danger mb-2" href="{{ action('MessageController@message', $partner->id) }}">
      {{ $partner->user }}さんにメッセージを送る
    </a>
    <!-- お気に入り芸人登録・解除ボタン -->
    <div class="mb-5">
      <form action="{{ url('/show') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="favoriteTo_id" value="{{ $partner->id }}">
        @auth('geinin')
        @forelse ($partner->favoriteTo as $favoriteTo)
        @if ($favoriteTo->favoriteFrom_id == $auth_geinin->id)
        @method('delete')
        <input class="btn btn-warning" style="cursor: pointer;" type="submit" value="お気に入り芸人解除">
        @elseif ($loop->last)
        @method('patch')
        <input class="btn btn-warning" style="cursor: pointer;" type="submit" value="お気に入り芸人登録">
        @endif
        @empty
        @method('patch')
        <input class="btn btn-warning" style="cursor: pointer;" type="submit" value="お気に入り芸人登録">
        @endforelse
        @else
        @method('patch')
        <input class="btn btn-warning" style="cursor: pointer;" type="submit" value="お気に入り芸人登録">
        @endauth
      </form>
    </div>
  </div>
  @if($loop->iteration % 2 == 0)
</div>
<div class="row">
  @endif
  @break($loop->iteration == 4)

  @empty
  <p class="col">残念ながら、条件の合う芸人が見つかりませんでした</p>
  @endforelse
</div>
@endsection