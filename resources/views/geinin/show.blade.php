@extends('layouts.geininapp')

@section('title', '相方マッチングサイト')

@section('body')
<h2 class="mb-5">あなたの相性の良い相方</h2>
@foreach ($partners as $partner)
<figure>
@if ($partner->image != null)
  <img src="/geininMatching/public/storage/{{ $partner->image }}" class="rounded-circle" width="150" height="150" alt="画像">
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
<a class="btn btn-danger" href="#">
  {{ $partner->user }}さんにメッセージを送る
</a>
@endforeach
@endsection
