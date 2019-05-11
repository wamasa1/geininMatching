@extends('layouts.geininapp')

@section('title')
 ログイン画面
 <a class="float-right mt-3 btn btn-primary btn-lg" href="/geininMatching/public/index" role="button">戻る</a>
@endsection

@section('body')
  <form action="/geininMatching/public/login" method="post">
  {{ csrf_field() }}
  <table id="question" class="table table-hover">
    <tr>
      <th class="align-middle bg-dark text-white">
        メールアドレス
      </th>
      <td>
        <input type="email" name="email" value="{{ old('email') }}">
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
        <!-- @if ($errors->has('password'))
        <p class="text-danger">{{ $errors->first('password') }}</p>
        @endif -->
      </td>
    </tr>
  </table>
  <input class="btn-primary btn-lg" type="submit" value="ログイン">
  </form>
@endsection
