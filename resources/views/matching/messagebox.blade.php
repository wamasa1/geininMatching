@extends('layouts.matching')

@section('title', 'メッセージ・ボックス')

@section('header')
  <div class="text-right pt-5 mt-5">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  <h1 class="text-danger display-3 pt-2 mt-2 mb-5">メッセージ・ボックス</h1>
@endsection

@section('body')
{{-- 送信完了のメッセージ --}}
@if (session('message_success'))
<div class="alert alert-success mt-5">
  {{ session('message_success') }}
</div>
@endif

<table class="table">
  <tr>
    {{ $receiver_user }}さんのメッセージ・ボックス
  </tr>
  <tr>
    <td>From</td>
    <td>Message</td>
  </tr>
  @foreach ($senders as $sender)
  <tr>
    <td>{{ $sender->geininSender->user }}さん</td>
    <td>{{ $sender->message }}</td>
    <td>
      <a class="btn btn-danger" href="{{ action('MessageController@message', $sender->sender_id)}}">
        返信する
      </a>
    </td>
  </tr>
  @endforeach
</table>
@endsection
