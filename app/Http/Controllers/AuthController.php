<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function getAuth(Request $request)
  {
    return view('geinin.login');
  }

  public function postAuth(Request $request)
  { //テストユーザーでログイン
    if ($request->test_user_id == 1) {
      Auth::guard('geinin')->loginUsingId(1);
      return redirect()->intended('/search')->with('login', 'ログインしました');
    }
    //認証 email passwordの照合
    $credentials = $request->only('email', 'password');

    if (Auth::guard('geinin')->attempt($credentials)) {
      return redirect()->intended('/search')->with('login', 'ログインしました');
    } else {
      return redirect('/login')->with('login_failure', 'ログインに失敗しました');
    }
  }

  public function logout()
  {
    Auth::guard('geinin')->logout();
    return redirect('/')->with('logout', 'ログアウトしました');
  }
}
