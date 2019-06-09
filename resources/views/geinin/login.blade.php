@extends('layouts.geinin')

@section('title', 'ログイン画面')

@section('header')
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/index') }}" role="button">
    ホーム
  </a>
</div>
<h1 id="title-font-size" class="display-3 pt-2 mt-2 mb-5">ログイン画面</h1>
@endsection

@section('body')
  <form action="{{ url('/login') }}" method="post">
  {{ csrf_field() }}
  <table id="question" class="table">
    <tr>
      <th class="align-middle bg-dark text-white">
        メールアドレス
      </th>
      <td>
        <input type="email" name="email" value="{{ old('email') }}">
        <br><span class="text-primary">テストユーザー用：ikuta@gmail.com</span>
        <!-- @if ($errors->has('email'))
        <p class="text-danger">{{ $errors->first('email') }}</p>
        @endif -->
      </td>
    </tr>
    <tr>
      <th class="align-middle bg-dark text-white">
        パスワード(4文字以上)
      </th>
      <td>
        <input type="password" name="password">
        <br><span class="text-primary">テストユーザー用：ikuta</span>
        <!-- @if ($errors->has('password'))
        <p class="text-danger">{{ $errors->first('password') }}</p>
        @endif -->
      </td>
    </tr>
  </table>
{{--　ログイン失敗メッセージ　--}}
  @if (session('login_failure'))
  <div class="alert alert-success mt-3">
    {{ session('login_failure') }}
  </div>
  @endif

  <input class="btn-primary btn-lg" type="submit" value="ログイン">
  </form>
  <p class="mt-5">未登録の方はこちらへ</p>
  <a class="btn btn-danger btn-lg" href="{{ url('/register')}}" role="button">
    新規登録
  </a>
@endsection
