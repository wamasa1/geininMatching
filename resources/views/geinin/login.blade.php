@extends('layouts.geinin')

@section('title', 'ログイン画面')

@section('header')
  <div class="text-right mt-1">
    <a class="btn btn-primary" href="{{ url('/') }}" role="button">
      ホーム
    </a>
  </div>
  <h1 id="title-font" class="display-3 pt-2 mt-2 mb-5">ログイン画面</h1>
@endsection

@section('body')
  <div style="background-color: ghostwhite;">
    <form action="{{ url('/login') }}" method="post">
      {{ csrf_field() }}
      <table id="question" class="table">
        <tr>
          <th class="align-middle bg-dark text-white text-nowrap">
            メールアドレス
          </th>
          <td>
            <input type="email" size="17" name="email" value="{{ old('email') }}">
          </td>
        </tr>
        <tr>
          <th class="align-middle bg-dark text-white text-nowrap">
            パスワード<br>(4文字以上)
          </th>
          <td>
            <input type="password" size="17" name="password">
          </td>
        </tr>
      </table>

      <!-- ログイン失敗メッセージ -->
      @include('shared.flash_message', ['message' => 'login_failure'])
      
      <input class="btn btn-primary" style="cursor: pointer;" type="submit" value="ログイン">
    </form>
  </div>

  <p class="mt-4 mb-0">未登録の方はこちらへ</p>
  <a class="btn btn-danger" href="{{ url('/register')}}" role="button">
    新規登録
  </a>
  <!-- テストユーザー -->
  <p class="mt-4 mb-0">採用ご担当者様はこちらへ</p>
  <form action="{{ url('/login') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="test_user_id" value="1">
    <input class="btn btn-warning" style="cursor: pointer;" type="submit" value="テストユーザーでログイン">
  </form>
@endsection