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

<!-- 検索フォーム -->
<div class="mx-auto my-5 bg-light border border-primary" style="width: 360px;">
  <form action="{{ url('/search') }}" method="get">
    {{ csrf_field() }}
    <table class="table-sm text-left">
      <tr>
        <td class="text-nowrap">
          活動場所
        </td>
        <td>
          <select name="activity_place">
            <option value="no_select">未選択</option>
            <option value="tokyo" @if($activity_place=='tokyo' ) selected @endif>東京</option>
            <option value="osaka" @if($activity_place=='osaka' ) selected @endif>大阪</option>
            <option value="fukuoka" @if($activity_place=='fukuoka' ) selected @endif>福岡</option>
            <option value="sendai" @if($activity_place=='sendai' ) selected @endif>仙台</option>
            <option value="sapporo" @if($activity_place=='sapporo' ) selected @endif>札幌</option>
            <option value="okinawa" @if($activity_place=='okinawa' ) selected @endif>沖縄</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="text-nowrap">
          ジャンル
        </td>
        <td>
          <select name="genre">
            <option value="no_select">未選択</option>
            <option value="manzai" @if($genre=='manzai' ) selected @endif>漫才</option>
            <option value="konto" @if($genre=='konto' ) selected @endif>コント</option>
            <option value="both" @if($genre=='both' ) selected @endif>両方</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>
          役割
        </td>
        <td class="text-left">
          <select name="role">
            <option value="no_select">未選択</option>
            <option value="boke" @if($role=='boke' ) selected @endif>ボケ</option>
            <option value="tukkomi" @if($role=='tukkomi' ) selected @endif>ツッコミ</option>
            <option value="boke_tukkomi" @if($role=='boke_tukkomi' ) selected @endif>両方</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>
          ネタ作り
        </td>
        <td>
          <select name="creater">
            <option value="no_select">未選択</option>
            <option value="me" @if($creater=='me') selected @endif>自分が作る</option>
            <option value="together" @if($creater=='together') selected @endif>一緒に作りたい</option>
            <option value="you" @if($creater=='you') selected @endif>相方に作ってほしい</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>
          目標
        </td>
        <td>
          <select name="target">
            <option value="no_select">未選択</option>
            <option value="golden" @if($target=='golden') selected @endif>ゴールデンで冠番組を持つ</option>
            <option value="midnight" @if($target=='midnight') selected @endif>深夜で面白い番組がしたい</option>
            <option value="theater" @if($target=='theater') selected @endif>テレビより舞台で活躍したい</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>キーワード</td>
        <td><input type="text" name="keyword" value="{{ $keyword }}"></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="検索"></td>
      </tr>
    </table>
  </form>
</div>

<p class="font-weight-bold text-primary">現在、全{{ $allCount }}件中{{ $hitCount }}件がヒット！</p>

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
{{ $geinins->appends(['activity_place' => $activity_place, 'genre' => $genre, 'role' => $role, 'creater' => $creater, 'target' => $target, 'keyword' => $keyword])->onEachSide(1)->links() }}
@endif
@endsection