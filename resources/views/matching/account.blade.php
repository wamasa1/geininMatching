@extends('layouts.matching')

@section('title', '登録情報')

@section('header')
  <div class="text-right mt-1">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
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
            <div class="form-group">
              <label for="exampleInputPassword1">現在のパスワード</label>
              <input name="current_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="現在のパスワード">
              @if ($errors->has('current_password'))
              <p class="text-danger">{{ $errors->first('current_password') }}</p>
              @endif
              <!-- 現在のパスワードが異なる旨のメッセージ -->
              @if (session('password_failure'))
              <div class="alert alert-danger">
                {{ session('password_failure') }}
              </div>
              @endif
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">新しいパスワード</label>
              <input name="new_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="新しいパスワード" aria-describedby="passwordHelp">
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
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <p>{{ $geinin->user }}さんの登録情報を全て削除します。<br>一度削除した場合、データの復元はできませんが、よろしいですか？</p>
        <form action="{{ url('/account') }}" method="post">
          {{ csrf_field() }}
          @method('delete')
          <input class="btn btn-primary" type="submit" value="削除する" style="cursor: pointer"><br>
          <small>※テストユーザーは削除されません</small>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
