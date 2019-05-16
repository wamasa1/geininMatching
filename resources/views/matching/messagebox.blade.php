@extends('layouts.geininapp')

@section('title', 'メッセージ・ボックス')

@section('header')
 メッセージ・ボックス
  <div class="text-right">
    <a class="btn btn-primary" href="{{ url('/search') }}" role="button">
      検索画面へ
    </a>
  </div>
@endsection

@section('body')
{{-- 送信完了のメッセージ --}}
@if (session('submit'))
<div class="alert alert-success mt-5">
  {{ session('submit') }}
</div>
@endif

<table class="table">
  <tr class="">
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
      <a class="btn btn-danger" href="{{ action('MessageController@message', $sender->sender_id) }}">
        返信する
      </a>
    </td>
  </tr>
  @endforeach
</table>
@endsection
