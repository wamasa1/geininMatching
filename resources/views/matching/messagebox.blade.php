@extends('layouts.matching')

@section('title', 'メッセージ・ボックス')

@section('header')
  <div class="text-right mt-1">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  <h1 id="title-font" class="text-danger display-3 pt-2 mt-2 mb-5">メッセージ・ボックス</h1>
@endsection

@section('body')
  <!-- 送信完了のメッセージ -->
  @if (session('message_success'))
    <div class="alert alert-success mt-5">
      {{ session('message_success') }}
    </div>
  @endif

  <!-- 受信ボックス -->
  <div class="bg-dark text-white font-weight-bold">
    {{ $receiver_user }}さんの受信ボックス
  </div>
  <table class="table">
    <tr>
      <td></td>
      <td>From</td>
      <td>Message</td>
    </tr>
    @foreach ($senders as $sender)
      <!-- 既読未読判定 -->
      @if ($sender->readed == 2)
        <tr class="font-weight-light text-muted">
          <td>
            <span class="badge badge-secondary">既読</span>
          </td>
      @else
        <tr class="font-weight-bold bg-light">
          <td>
            <span class="badge badge-danger">未読</span>
          </td>
      @endif
          <td>
            <a href="{{ url('/profile/' . $sender->sender_id) }}" target="_blank">{{ $sender->geininSender->user }}さん</a>
          </td>
          <td>{{ $sender->message }}</td>
          <td>
            <a class="btn btn-sm btn-danger" href="{{ action('MessageController@message', $sender->sender_id)}}">
              返信する
            </a>
          </td>
        </tr>
    @endforeach
  </table>

  <!-- 送信済みメッセージ -->
  <div class="bg-dark text-white font-weight-bold mt-5">
    {{ $receiver_user }}さんの送信済みメッセージ
  </div>
  <table class="table">
    <tr class="font-weight-bold">
      <td>To</td>
      <td>Message</td>
    </tr>
    @foreach ($sent_messages as $sent_message)
      <tr>
        <td>
          <a href="{{ url('/profile/' . $sent_message->receiver_id) }}" target="_blank">{{ $sent_message->geininReceiver->user }}さん</a>
        </td>
        <td>{{ $sent_message->message }}</td>
      </tr>
    @endforeach
  </table>
@endsection
