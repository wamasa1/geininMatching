@extends('layouts.matching')

@section('title', 'プロフィール編集画面')

@section('header')
  <div class="text-right pt-5 mt-5">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  <h1 class="text-success display-3 pt-2 mt-2 mb-5">プロフィール編集画面</h1>
@endsection

@section('body')

@empty (!$geinin->image)
<figure>
  <img src="/geininMatching/public/storage/{{ $geinin->image }}" class="rounded-circle" alt="画像">
  <figcaption>現在のプロフィール画像</figcaption>
</figure>
@endempty

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

<form class="mt-5" action="/geininMatching/public/profile" method="post" enctype="multipart/form-data">
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
