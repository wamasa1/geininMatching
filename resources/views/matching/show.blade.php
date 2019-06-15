@extends('layouts.matching')

@section('title', 'あなたの相性の良い相方')

@section('header')
  <div class="text-right mt-1">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  <h1 id="title-font-size" class="text-primary display-3 pt-2 mt-2 mb-5">あなたの相性の良い相方</h1>
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

<div class="row">
@forelse ($partners as $partner)
  <div class="col">
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
          <td>{{ $partner->user }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">漫才とコントのどちらがやりたいですか？</th>
          <td>{{ $partner->genre }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">ボケとツッコミのどちらを担当したいですか？</th>
          <td>{{ $partner->role }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">ネタは作りますか？</th>
          <td>{{ $partner->creater }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">目標</th>
          <td>{{ $partner->target }}</td>
        </tr>
        <tr>
          <th class="align-middle bg-primary text-white">自己紹介</th>
          <td>{{ $partner->self_introduce }}</td>
        </tr>
      </tbody>
    </table>
    <a class="btn btn-danger mb-2" href="{{ action('MessageController@message', $partner->id) }}">
      {{ $partner->user }}さんにメッセージを送る
    </a>
    <div>
      <form action="{{ url('/show') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="favoriteTo_id" value="{{ $partner->id }}">
        @isset($auth_id)
          @forelse ($partner->favoriteTo as $favoriteTo)
            @if ($favoriteTo->favoriteFrom_id == $auth_id)
              @method('delete')
              <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人解除">
            @endif
          @empty
            @method('patch')
            <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人登録">
          @endforelse
        @endisset
      </form>
    </div>
  </div>
@if($loop->iteration % 2 == 0)
</div>
<div class="row">
@endif
@break($loop->iteration  == 4)

@empty
<p>見つかりませんでした</p>
@endforelse
</div>
@endsection
