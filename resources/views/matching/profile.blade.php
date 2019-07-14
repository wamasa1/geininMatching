@extends('layouts.matching')

@section('title', 'プロフィール')

@section('header')
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
    ログアウト
  </a>
</div>
<h1 id="title-font" class="text-success display-3 pt-2 mt-2 mb-5">プロフィール</h1>
@endsection

@section('body')
<div style="background-color: honeydew;">
  <!-- プロフィール画像 -->
  <figure>
    @if ($geinin->image == null)
    <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
    @else
    <img src="{{ Storage::disk('s3')->url('images/' . $geinin->image) }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
    @endif
    <figcaption>プロフィール画像</figcaption>
  </figure>
  <!-- アップロード成功メッセージ -->
  @if (session('image_success'))
  <div class="alert alert-success">
    {{ session('image_success') }}
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

  <form class="mt-3 mb-5 pb-5" action="{{ url('/profile') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="image">
    <input type="submit" value="アップロード">
  </form>
  <!-- 編集成功メッセージ -->
  @if (session('profile_success'))
  <div class="alert alert-success">
    {{ session('profile_success') }}
  </div>
  @endif
  <!-- 編集ボタン -->
  <div class="text-center">
    <a class="btn btn-success col-4" href="{{ url('/profile/edit') }}">編集</a>
  </div>
  <!-- プロフィール -->
  <table id="profile-table" class="table mt-1">
    <thead>
    </thead>
    <tbody>
      <tr>
        <th class="align-middle bg-success text-white">ユーザー名</th>
        <td>{{ $geinin->user }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">年齢</th>
        <td>{{ $geinin->age }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">希望の活動場所</th>
        <td>{{ $geinin->activity_place }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">漫才とコントのどちらがやりたいですか？</th>
        <td class="align-middle">{{ $geinin->genre }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">ボケとツッコミのどちらを担当したいですか？</th>
        <td class="align-middle">{{ $geinin->role }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">ネタは作りますか？</th>
        <td>{{ $geinin->creater }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">目標</th>
        <td>{{ $geinin->target }}</td>
      </tr>
      <th class="align-middle bg-success text-white">得意なモノマネ</th>
      <td>{{ $geinin->monomane }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">好きな芸人</th>
        <td>{{ $geinin->favorite_geinin }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">好きなネタ</th>
        <td>{{ $geinin->favorite_neta }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">好きなテレビ番組</th>
        <td>{{ $geinin->favorite_tv_program }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">最近笑ったこと</th>
        <td>{{ $geinin->laughing_event }}</td>
      </tr>
      <tr>
        <th class="align-middle bg-success text-white">自己紹介</th>
        <td>{{ $geinin->self_introduce }}</td>
      </tr>
    </tbody>
  </table>
</div>
@endsection