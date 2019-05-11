@extends('layouts.geininapp')

@section('title', 'プロフィール編集画面')

@section('body')
  <h2>プロフィールを充実させよう</h2>
  <div class="text-right">
    <a class="btn btn-primary" href="/geininMatching/public/logout" role="button">
      ログアウト
    </a>
  </div>

@if ($geinin->image != null)
<figure>
  <img src="/geininMatching/public/storage/{{ $geinin->image }}" class="rounded-circle" alt="画像">
  <figcaption>現在のプロフィール画像</figcaption>
</figure>
@endif

@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif

<form action="/geininMatching/public/profile" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="file" name="image">
  <input type="submit" value="アップロード">
</form>

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
@endsection
