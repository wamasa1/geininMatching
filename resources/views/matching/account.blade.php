@extends('layouts.matching')

@section('title', '登録情報')

@section('header')
  @include('shared.logout_button')
  <h1 id="title-font" class="text-dark display-3 pt-2 mt-2 mb-5">登録情報変更</h1>
@endsection

@section('body')
<!-- パスワード変更完了メッセージ -->
@if (session('password_success'))
<div class="alert alert-success mt-5">
  {{ session('password_success') }}
</div>
@endif
<!-- テストユーザー -->
@if (session('test_user'))
<div class="alert alert-danger mt-5">
  {{ session('test_user') }}
</div>
@endif

<div class="accordion" id="accordionExample">
  <!-- パスワード変更 -->
  <div class="card">
    <div class="card-header bg-dark" id="headingOne">
      <h4 class="mb-0">
        <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="cursor: pointer">
          パスワード変更
        </button>
      </h4>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <form action="{{ url('/account') }}" method="post">
          {{ csrf_field() }}
          <!-- 現在のメールアドレス -->
          <div class="form-group">
            <label for="email">現在のメールアドレス</label>
            <input name="current_email" type="email" class="form-control" id="email" placeholder="現在のメールアドレス">
            @if ($errors->has('current_email'))
            <p class="text-danger">{{ $errors->first('current_email') }}</p>
            @endif
          </div>
          <!-- 現在のパスワード -->
          <div class="form-group">
            <label for="password1">現在のパスワード</label>
            <input name="current_password" type="password" class="form-control" id="password1" placeholder="現在のパスワード">
            @if ($errors->has('current_password'))
            <p class="text-danger">{{ $errors->first('current_password') }}</p>
            @endif
            <!-- パスワード又はアドレスの不一致メッセージ -->
            @if (session('password_failure'))
            <div class="alert alert-danger mt-2">
              {{ session('password_failure') }}
            </div>
            @endif
          </div>
          <div class="form-group">
            <label for="password1">新しいパスワード</label>
            <input name="new_password" type="password" class="form-control" id="password1" placeholder="新しいパスワード" aria-describedby="passwordHelp">
            <small id="passwordHelp" class="form-text text-muted">４文字以上</small>
            @if ($errors->has('new_password'))
            <p class="text-danger">{{ $errors->first('new_password') }}</p>
            @endif
          </div>
          <input class="btn btn-primary" type="submit" value="変更する" style="cursor: pointer"><br>
          <small>※テストユーザーは変更されません</small>
        </form>
      </div>
    </div>
  </div>
  <!-- アカウント削除 -->
  <div class="card">
    <div class="card-header bg-dark" id="headingTwo">
      <h4 class="mb-0">
        <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="cursor: pointer">
          アカウント削除
        </button>
      </h4>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <form action="{{ url('/account') }}" method="post">
          {{ csrf_field() }}
          @method('delete')
          <!-- 現在のメールアドレス -->
          <div class="form-group">
            <label for="email">現在のメールアドレス</label>
            <input name="current_email_del" type="email" class="form-control" id="email" placeholder="現在のメールアドレス">
            @if ($errors->has('current_email_del'))
            <p class="text-danger">{{ $errors->first('current_email_del') }}</p>
            @endif
          </div>
          <!-- 現在のパスワード -->
          <div class="form-group">
            <label for="password2">現在のパスワード</label>
            <input name="current_password_del" type="password" class="form-control" id="password2" placeholder="現在のパスワード">
            @if ($errors->has('current_password_del'))
            <p class="text-danger">{{ $errors->first('current_password_del') }}</p>
            @endif
            <!-- パスワード又はアドレスの不一致メッセージ -->
            @if (session('del_failure'))
            <div class="alert alert-danger mt-2">
              {{ session('del_failure') }}
            </div>
            @endif
          </div>

          <p>{{ $auth_geinin->user }}さんの登録情報を全て削除します。<br>一度削除した場合、データの復元はできませんが、よろしいですか？</p>
          <input class="btn btn-primary" type="submit" value="削除する" style="cursor: pointer"><br>
          <small>※テストユーザーは削除されません</small>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection