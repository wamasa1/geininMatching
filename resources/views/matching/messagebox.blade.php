@extends('layouts.matching')

@section('title', 'メッセージ・ボックス')

@section('header')
  @include('shared.logout_button')
  <h1 id="title-font" class="text-danger display-3 pt-2 mt-2 mb-5">メッセージ・ボックス</h1>
@endsection

@section('body')
  <!-- メッセージ送信完了メッセージ -->
  @include('shared.flash_message', ['message' => 'message_success'])
  <p class="mb-4">{{ $receiver_user }}さん</p>
  <!-- Navs -->
  <div style="background-color: snow;">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#receive" role="tab" aria-controls="receive" aria-selected="true">受信ボックス</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#send" role="tab" aria-controls="send" aria-selected="false">送信済み</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <!-- 受信ボックス -->
      <div class="tab-pane fade show active" id="receive" role="tabpanel" aria-labelledby="receive-tab">
        <table class="table">
          <tr>
            <td></td>
            <td>日時</td>
            <td>From</td>
            <td>Message</td>
            <td></td>
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
              <td>{{ $sender->created_at->format('m/d H:i') }}</td>
              <td>
                <a href="{{ url('/profile/' . $sender->sender_id) }}">{{ $sender->geininSender->user }}</a>
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
      </div>
      <!-- 送信済みメッセージ -->
      <div class="tab-pane fade" id="send" role="tabpanel" aria-labelledby="send-tab">
        <table class="table">
          <tr class="font-weight-bold">
            <td>日時</td>
            <td>To</td>
            <td>Message</td>
          </tr>
          @foreach ($sent_messages as $sent_message)
            <tr>
              <td>{{ $sent_message->created_at->format('m/d H:i') }}</td>
              <td>
                <a href="{{ url('/profile/' . $sent_message->receiver_id) }}" target="_blank">{{ $sent_message->geininReceiver->user }}</a>
              </td>
              <td>{{ $sent_message->message }}</td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
@endsection