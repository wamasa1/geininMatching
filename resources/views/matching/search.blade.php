@extends('layouts.geininapp')

@section('title', '検索画面')

@section('body')
  {{-- 検索フォーム --}}
  <div class="my-5">
    <form action="/geininMatching/public/search" method="get">
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

  {{-- 芸人一覧 --}}
  <div class="row">
  @foreach($geinins as $geinin)
    <div class="col">
      <figure>
      @if ($geinin->image != null)
        <img src="/geininMatching/public/storage/{{ $geinin->image }}" class="rounded-circle" width="150" height="150" alt="画像">
      @else
        <img src="{{ asset('/images/noimage.png') }}" class="rounded-circle" width="150" height="150">
      @endif
        <figcaption>現在のプロフィール画像</figcaption>
      </figure>

      <table id="question" class="table table-hover">
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
    </div>
  @if($loop->iteration % 2 == 0)
  </div>
  <div class="row">
  @endif
  @endforeach
  </div>
  @if (!empty($genre))
  {{ $geinins->appends(['genre' => $genre, 'role' => $role,  'creater' => $creater, 'target' => $target])->links() }}
  @endif
@endsection
