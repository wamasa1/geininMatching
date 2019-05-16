@extends('layouts.geininapp')

@section('title', 'メッセージ・フォーム')

@section('header')
 メッセージ・フォーム
  <div class="text-right">
    <a class="btn btn-primary" href="{{ url('/show') }}" role="button">
      戻る
    </a>
  </div>
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
