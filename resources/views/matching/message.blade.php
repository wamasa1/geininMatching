@extends('layouts.matching')

@section('title', 'メッセージ・フォーム')

@section('header')
<div class="text-right mt-1">
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
      <td class="text-nowrap">送信先</td>
      <td>{{ $geinin->user }}さん</td>
    </tr>
    <tr>
      <td colspan="2">
        <textarea class="w-100 h-20" name="message" rows="8" cols="50" placeholder="メッセージ" value="{{ old('message')}}"></textarea>
      </td>
    </tr>
  </table>
  <input type="hidden" name="id" value="{{ $geinin->id }}">
  <input type="submit" value="送信">
</form>
@endsection
