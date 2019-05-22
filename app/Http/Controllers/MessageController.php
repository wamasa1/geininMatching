<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geinin;
use App\Message;
use Illuminate\Support\Facades\Auth;

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

      $geinin = Geinin::findOrFail($request->id);
      //リダイレクト先は二つ前のページ
      $redirectTo = $request->session()->get('redirectTo');
      return redirect($redirectTo)
        ->with('message_success', $geinin->user . 'さんに送信しました');
    }

    public function receive ()
    {
      //receiverのid,user名
      $receiver_id = Auth::guard('geinin')->id();
      $receiver = Geinin::findOrFail($receiver_id);
      $receiver_user = $receiver->user;

      //senders
      $senders = $receiver->messageReceiver;

      $param = [
        'receiver_user' => $receiver_user,
        'senders' => $senders,
      ];
      return view('matching.messagebox', $param);
    }
}
