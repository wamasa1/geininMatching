@extends('layouts.matching')

@section('title', 'あなたの相性の良い相方')

@section('header')
  <div class="text-right pt-5 mt-5">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  <h1 class="text-primary display-3 pt-2 mt-2 mb-5">あなたの相性の良い相方</h1>
@endsection

@section('body')
{{-- 送信完了のメッセージ --}}
@if (session('submit'))
<div class="alert alert-success mt-5">
  {{ session('submit') }}
</div>
@endif

<div class="row">
@forelse ($partners as $partner)
  <div class="col">
  <figure>
  @if ($partner->image != null)
    <img src="/geininMatching/public/storage/{{ $partner->image }}" class="rounded-circle" width="200" height="200" alt="画像">
  @else
    <img src="{{ asset('/images/noimage.png') }}" class="rounded-circle" width="200" height="200">
  @endif
    <figcaption>現在のプロフィール画像</figcaption>
  </figure>

  <table id="question" class="table table-hover">
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
  <a class="btn btn-danger mb-5" href="{{ action('MessageController@message', $partner->id) }}">
    {{ $partner->user }}さんにメッセージを送る
  </a>
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
