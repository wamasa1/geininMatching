@extends('layouts.matching')

@section('title', '検索画面')

@section('header')
  {{-- 認証時はログアウトボタン それ以外の時はログインボタン --}}
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

  <h1 id="title-font-size" class="text-secondary display-3 pt-2 my-2">検索画面</h1>
@endsection


@section('body')
{{-- メッセージ送信完了メッセージ --}}
@if (session('message_success'))
<div class="alert alert-success mt-5">
  {{ session('message_success') }}
</div>
@endif

{{-- お気に入り登録完了メッセージ --}}
@if (session('favorite_success'))
<div class="alert alert-success mt-5">
  {{ session('favorite_success') }}
</div>
@endif

{{-- お気に入り登録解除メッセージ --}}
@if (session('favorite_delete'))
<div class="alert alert-success mt-5">
  {{ session('favorite_delete') }}
</div>
@endif

  {{-- 検索フォーム --}}
  <div class="my-5 bg-light border border-primary">
    <form action="{{ url('/search') }}" method="get">
      {{ csrf_field() }}
      <table class="table-sm text-left">
        <tr>
          <td class="text-nowrap">
            ジャンル
          </td>
          <td>
            <select name="genre">
              <option value="manzai">漫才</option>
              <option value="konto">コント</option>
              <option value="both">両方</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            役割
          </td>
          <td class="text-left">
            <select name="role">
              <option value="boke">ボケ</option>
              <option value="tukkomi">ツッコミ</option>
              <option value="boke_tukkomi">両方</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            ネタ作り
          </td>
          <td>
            <select name="creater">
              <option value="me">自分が作る</option>
              <option value="together">一緒に作りたい</option>
              <option value="you">相方に作ってほしい</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            目標
          </td>
          <td>
            <select name="target">
              <option value="golden">ゴールデンで冠番組を持つ</option>
              <option value="midnight">深夜で面白い番組がしたい</option>
              <option value="theater">テレビより舞台で活躍したい</option>
            </select>
          </td>
          <td><input type="submit" value="検索"></td>
        </tr>
      </table>
    </form>
  </div>

  <p class="font-weight-bold text-primary">現在、全{{ $allCount }}件中{{ $hitCount }}件がヒット！</p>

  {{-- 芸人一覧 --}}
  <div class="row">
  @if($geinins)
    @foreach($geinins as $geinin)
      <div class="col">
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
      </div>
      @if($loop->iteration == 2)
      </div>
      <div class="row">
      @endif
    @endforeach
  </div>

  {{ $geinins->appends(['genre' => $genre, 'role' => $role,  'creater' => $creater, 'target' => $target])->links() }}
  @endif
@endsection
