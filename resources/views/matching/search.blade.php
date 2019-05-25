@extends('layouts.matching')

@section('title', '検索画面')

@section('header')
  {{-- 認証時はログアウトボタン それ以外の時はログインボタン--}}
  @if ($auth)
  <div class="text-right pt-5 mt-5">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  @else
  <div class="text-right pt-5 mt-5">
    <a class="btn btn-primary" href="{{ url('/login') }}" role="button">
      ログイン
    </a>
  </div>
  @endif

  <h1 class="text-secondary display-3 pt-2 my-2">検索画面</h1>
@endsection

@section('body')
{{-- メッセージ送信完了 --}}
@if (session('message_success'))
<div class="alert alert-success mt-5">
  {{ session('message_success') }}
</div>
@endif

{{-- お気に入り登録完了 --}}
@if (session('favorite_success'))
<div class="alert alert-success mt-5">
  {{ session('favorite_success') }}
</div>
@endif

{{-- お気に入り登録解除 --}}
@if (session('favorite_delete'))
<div class="alert alert-success mt-5">
  {{ session('favorite_delete') }}
</div>
@endif

  {{-- 検索フォーム --}}
  <div class="my-5 bg-light border border-primary">
    <h2>検索項目</h2>
    <form action="{{ url('/search') }}" method="get">
      {{ csrf_field() }}
      <table class="table-sm mx-auto text-left">
        <tr>
          <td>
            <label>ジャンル</label>
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
            <label>役割</label>
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
            <label>ネタ作り</label>
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
            <label>目標</label>
          </td>
          <td>
            <select name="target">
              <option value="golden">ゴールデンで冠番組を持つ</option>
              <option value="midnight">深夜でもいいから、面白い番組がしたい</option>
              <option value="theater">テレビよりも舞台で活躍したい</option>
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
  @foreach($geinins as $geinin)
    <div class="col">
      <figure>
      @empty (!$geinin->image)
        <img src="/geininMatching/public/storage/{{ $geinin->image }}" class="rounded-circle" width="150" height="150" alt="画像">
      @else
        <img src="{{ asset('/images/noimage.png') }}" class="rounded-circle" width="150" height="150">
      @endempty
        <figcaption>プロフィール画像</figcaption>
      </figure>

      <table id="question" class="table table-hover mb-2">
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
      <div class="mb-5">
        <form action="{{ url('/search') }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="favoriteTo_id" value="{{ $geinin->id }}">
          @auth('geinin')
            @forelse ($geinin->favoriteTo as $favoriteTo)
              @if ($favoriteTo->favoriteFrom_id == $auth_id)
                @method('delete')
                <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人解除">
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
@endsection
