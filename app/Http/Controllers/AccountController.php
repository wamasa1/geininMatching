<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use App\Geinin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index ()
    {
      $geinin = Auth::guard('geinin')->user();

      return view('matching.account', ['geinin' => $geinin]);
    }

    public function post (PasswordRequest $request)
    {
      $geinin = Auth::guard('geinin')->user();
      //テストユーザー
      if ($geinin->user == '松本紳助（テスト）') {
        return redirect('/account')->with('test_user', 'テストユーザーであるため、パスワードは変更できません');
      }
      //パスワード照合、変更
      if (Hash::check($request->current_password, $geinin->password)) {
        $geinin->password = Hash::make($request->new_password);
        $geinin->save();
        return redirect('/account')->with('password_success', 'パスワードを変更しました');
      } else {
        return redirect('/account')->with('password_failure', '現在のパスワードが異なるため、変更できませんでした');
      }
    }

    public function delete ()
    {
      $geinin = Auth::guard('geinin')->user();
      //テストユーザー
      if ($geinin->user == '松本紳助（テスト）') {
        return redirect('/account')->with('test_user', 'テストユーザーであるため、アカウントは削除できません');
      }
      //アカウント削除
      $geinin->delete();

      return redirect('/')->with('account_delete', 'アカウントが削除されました');
    }
}
