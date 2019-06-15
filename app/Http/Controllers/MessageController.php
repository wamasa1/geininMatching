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
    public function message (Request $request, $id)
    {
      //送信後のリダイレクト先をセッションに保存
      $session = $request->session()->all();
      $previous = $session['_previous']['url'];
      $request->session()->put('redirectTo', $previous);

      $geinin = Geinin::findOrFail($id);
      return view('matching.message', ['geinin' => $geinin, 'id' => $id]);
    }

    public function submit (Request $request)
    {
      $message = new Message();
      $message->receiver_id = $request->id;
      $message->sender_id = Auth::guard('geinin')->id();
      $message->message = $request->message;
      $message->save();

      $receiver = Geinin::findOrFail($request->id);
      $sender = Auth::guard('geinin')->user();

      //リダイレクト先
      $redirectTo = $request->session()->get('redirectTo');
      if ($redirectTo == url('/profile/' . $request->id) or
          $redirectTo == url('/message/' . $request->id)) {
        $redirectTo = url('/messagebox');
      };

      //受信者に受信をお知らせするメール送信
      $title = '[相方マッチングサイト]メッセージ受信のお知らせ';
      $text = $sender->user . 'さんからメッセージが届いております。';
      Mail::to($receiver->email)->send(new MessageNotification($title,$text));

      return redirect($redirectTo)
        ->with('message_success', $receiver->user . 'さんに送信しました');
    }

    public function receive ()
    {
      //認証者（receiver）のid,user名
      $auth_id = Auth::guard('geinin')->id();
      $receiver = Geinin::findOrFail($auth_id);
      $receiver_user = $receiver->user;

      $senders = $receiver->messageReceiver;

      //認証者の送信済みメッセージ取得
      $sent_messages = Message::where('sender_id', $auth_id)->get();

      return view('matching.messagebox', [
        'receiver_user' => $receiver_user,
        'senders' => $senders,
        'sent_messages' => $sent_messages,
      ]);
    }
}
