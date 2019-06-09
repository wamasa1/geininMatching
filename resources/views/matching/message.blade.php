@extends('layouts.matching')

@section('title', 'メッセージ・フォーム')

@section('header')
<div class="text-right pt-5 mt-5">
  <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
    ログアウト
  </a>
</div>
<h1 id="title-font-size" class="text-danger display-3 pt-2 mt-2 mb-5">メッセージ・フォーム</h1>
@endsection

@section('body')
<form action="{{ url('/message/' . $id) }}" method="post">
  {{ csrf_field() }}
  <table class="table">
    <tr>
      <td>送信先</td>
      <td>{{ $geinin->user }}さん</td>
    </tr>
    <tr>
      <td>メッセージ</td>
      <td><textarea name="message" rows="8" cols="50" value="{{ old('message')}}"></textarea></td>
    </tr>
  </table>
  <input type="hidden" name="id" value="{{ $geinin->id }}">
  <input type="submit" value="送信">
</form>
@endsection
