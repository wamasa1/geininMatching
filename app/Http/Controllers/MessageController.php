<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geinin;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageNotification;

class MessageController extends Controller
{
  public function message(Request $request, $id)
  {
    $geinin = Geinin::findOrFail($id);
    return view('matching.message', ['geinin' => $geinin, 'id' => $id]);
  }

  public function submit(Request $request)
  {
    $message = new Message();
    $message->receiver_id = $request->id;
    $message->sender_id = Auth::guard('geinin')->id();
    $message->message = $request->message;
    $message->save();

    $receiver = Geinin::findOrFail($request->id);
    $sender = Auth::guard('geinin')->user();

    //受信者に受信をお知らせするメール送信
    $title = '[相方マッチングサイト]メッセージ受信のお知らせ';
    $text = $sender->user . 'さんからメッセージが届いております。';
    Mail::to($receiver->email)->send(new MessageNotification($title, $text));

    return redirect('/messagebox')
      ->with('message_success', $receiver->user . 'さんに送信しました');
  }

  public function receive()
  {
    $auth_id = Auth::guard('geinin')->id();
    $receiver = Geinin::findOrFail($auth_id);
    $receiver_user = $receiver->user;
    $senders = $receiver->messageReceiver()->orderBy('created_at', 'desc')->get();
    //readedの値に１プラス
    foreach ($senders as $sender) {
      if ($sender->readed < 2) {
        $sender->readed++;
        $sender->save();
      }
    }
    //認証者の送信済みメッセージ取得
    $sent_messages = Message::where('sender_id', $auth_id)->orderBy('created_at', 'desc')->get();

    return view('matching.messagebox', [
      'receiver_user' => $receiver_user,
      'senders' => $senders,
      'sent_messages' => $sent_messages,
    ]);
  }
}
