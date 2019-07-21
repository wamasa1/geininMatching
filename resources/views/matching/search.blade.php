@extends('layouts.matching')

@section('title', '検索画面')

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

<h1 id="title-font" class="text-secondary display-3 pt-2 my-2">検索画面</h1>
@endsection

@section('body')
<!-- メッセージ送信完了メッセージ -->
@if (session('message_success'))
<div class="alert alert-success mt-5">
  {{ session('message_success') }}
</div>
@endif

<!-- お気に入り登録完了メッセージ -->
@if (session('favorite_success'))
<div class="alert alert-success mt-5">
  {{ session('favorite_success') }}
</div>
@endif

<!-- お気に入り登録解除メッセージ -->
@if (session('favorite_delete'))
<div class="alert alert-success mt-5">
  {{ session('favorite_delete') }}
</div>
@endif

<div class="mx-auto mt-1 mb-3 border border-primary">
  <form action="{{ url('/search') }}" method="get">
    {{ csrf_field() }}
    <strong>完全ランダムで１人表示！その芸人が運命の相方かも！　</strong>
    <button type="submit" name="omikuji" value="true" class="my-2 btn btn-primary" style="cursor: pointer">
      おみくじ検索
    </button>
  </form>
</div>

<!-- 検索フォーム -->
<div class="mx-auto mt-1 mb-3 border border-primary">
  <form action="{{ url('/search') }}" method="get">
    {{ csrf_field() }}
    <!-- 活動場所 -->
    <fieldset>
      <h5 class="bg-light font-weight-bold">活動場所<small>（複数選択可）</small></h5>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="tokyo" name="activity_place[]" value="tokyo" @if (is_array($activity_place) && in_array("tokyo", $activity_place)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="tokyo">東京</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="osaka" name="activity_place[]" value="osaka" @if (is_array($activity_place) && in_array("osaka", $activity_place)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="osaka">大阪</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="fukuoka" name="activity_place[]" value="fukuoka" @if (is_array($activity_place) && in_array("fukuoka", $activity_place)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="fukuoka">福岡</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="sendai" name="activity_place[]" value="sendai" @if (is_array($activity_place) && in_array("sendai", $activity_place)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="sendai">仙台</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="sapporo" name="activity_place[]" value="sapporo" @if (is_array($activity_place) && in_array("sapporo", $activity_place)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="sapporo">札幌</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="okinawa" name="activity_place[]" value="okinawa" @if (is_array($activity_place) && in_array("okinawa", $activity_place)) checked @endif>
        <label class="form-check-label pl-0 pr-2" for="okinawa">沖縄</label>
      </div>
    </fieldset>
    <!-- 希望するジャンル -->
    <fieldset class="mt-2">
      <h5 class="bg-light font-weight-bold">希望するジャンル<small>（複数選択可）</small></h5>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="manzai" name="genre[]" value="manzai" @if (is_array($genre) && in_array("manzai", $genre)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="manzai">漫才</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="konto" name="genre[]" value="konto" @if (is_array($genre) && in_array("konto", $genre)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="konto">コント</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="both" name="genre[]" value="both" @if (is_array($genre) && in_array("both", $genre)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="both">両方</label>
      </div>
    </fieldset>
    <!-- 役割 -->
    <fieldset class="mt-2">
    <h5 class="bg-light font-weight-bold">役割<small>（複数選択可）</small></h5>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="boke" name="role[]" value="boke" @if (is_array($role) && in_array("boke", $role)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="boke">ボケ</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="tukkomi" name="role[]" value="tukkomi" @if (is_array($role) && in_array("tukkomi", $role)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="tukkomi">ツッコミ</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="boke_tukkomi" name="role[]" value="boke_tukkomi" @if (is_array($role) && in_array("boke_tukkomi", $role)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="boke_tukkomi">こだわらない</label>
      </div>
    </fieldset>
    <!-- ネタ作り -->
    <fieldset class="mt-2">
      <h5 class="bg-light font-weight-bold">ネタ作り<small>（複数選択可）</small></h5>
      <div class="form-check form-check-inline">
        <input class="form-check-input pt-1" type="checkbox" id="me" name="creater[]" value="me" @if (is_array($creater) && in_array("me", $creater)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="me">自分が作る</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="together" name="creater[]" value="together" @if (is_array($creater) && in_array("together", $creater)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="together">一緒に作りたい</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="you" name="creater[]" value="you" @if (is_array($creater) && in_array("you", $creater)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="you">相方に作ってほしい</label>
      </div>
    </fieldset>
    <!-- 目標 -->
    <fieldset class="mt-2">
    <h5 class="bg-light font-weight-bold">目標<small>（複数選択可）</small></h5>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="golden" name="target[]" value="golden" @if (is_array($target) && in_array("golden", $target)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="golden">ゴールデンで冠番組を持つ</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="midnight" name="target[]" value="midnight" @if (is_array($target) && in_array("midnight", $target)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="midnight">深夜で面白い番組がしたい</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="theater" name="target[]" value="theater" @if (is_array($target) && in_array("theater", $target)) checked @endif>
        <label class="form-check-label pl-0 pr-3" for="theater">テレビより舞台で活躍したい</label>
      </div>
    </fieldset>
    <!-- キーワード -->
    <fieldset class="mt-2 bg-light">
      <input class="py-1" type="search" name="keyword" value="{{ $keyword }}" placeholder="キーワードを入力">
    </fieldset>
    <!-- 並び順 -->
    <fieldset class="mt-2">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="order" id="orderFavorite" value="orderFavorite" {{ $order == 'orderFavorite' ? 'checked' : '' }}>
        <label class="form-check-label pl-0 pr-4" for="orderFavorite">人気順</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="order" id="orderRegister" value="orderRegister" {{ $order == 'orderRegister' ? 'checked' : '' }}>
        <label class="form-check-label pl-0" for="orderRegister">新規登録順</label>
      </div>
    </fieldset>
    <button type="submit" class="col-6 my-1 btn btn-primary" style="cursor: pointer">検索</button>
  </form>
</div>

<div class="my-2">
  <mark class="font-weight-bold">現在、全{{ $allCount }}件中{{ $hitCount }}件がヒット！</mark>
</div>

<!-- 芸人一覧 -->
<div class="row">
  @if($geinins)
  @foreach($geinins as $geinin)
  <div class="col col-md-6 border border-primary rounded-top" style="background-color: whitesmoke;">
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
          <th class="align-middle bg-primary text-white">ユーザー名</th>
          <td><a href="{{ url('/profile/' . $geinin->id) }}" target="_blank">{{ $geinin->user }}</a></td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">希望する活動場所</th>
          <td class="align-middle">{{ $geinin->activity_place }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">漫才とコントのどちらがやりたいですか？</th>
          <td class="align-middle">{{ $geinin->genre }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">ボケとツッコミのどちらを希望しますか？</th>
          <td class="align-middle">{{ $geinin->role }}</td>
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
          <td class="align-middle">{{ $geinin->self_introduce }}</td>
        </tr>
      </tbody>
    </table>
    <a class="btn btn-danger mb-2" href="{{ action('MessageController@message', $geinin->id) }}">
      {{ $geinin->user }}さんにメッセージを送る
    </a>
    <!-- お気に入り芸人登録・解除ボタン -->
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
  </div>
  @if($loop->iteration == 2)
</div>
<div class="row">
  @endif
  @endforeach
</div>

@if(!$omikuji)
{{ $geinins->appends(['activity_place' => $activity_place, 'genre' => $genre, 'role' => $role, 'creater' => $creater, 'target' => $target, 'keyword' => $keyword, 'order' => $order])->onEachSide(1)->links() }}
@endif

@endif
@endsection