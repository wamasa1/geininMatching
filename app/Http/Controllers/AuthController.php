<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function getAuth (Request $request)
  {
    //送信後のリダイレクト先をセッションに保存
    $session = $request->session()->all();
    $previous = $session['_previous']['url'];
    $request->session()->put('redirectTo', $previous);

    return view('geinin.login');
  }

  public function postAuth (Request $request)
  {
    //認証 email passwordの照合
    $credentials = $request->only('email', 'password');
    //リダイレクト先は二つ前のページ
    $redirectTo = $request->session()->get('redirectTo');

    if (Auth::guard('geinin')->attempt($credentials))
    {
      if ($redirectTo == url('/') or $redirectTo == url('/login'))
      {
        return redirect('/search')->with('login', 'ログインしました');
      }
      return redirect($redirectTo)->with('login', 'ログインしました');
    } else {
      return redirect('/login')->with('login_failure', 'ログインに失敗しました');
    }
  }

  public function logout ()
  {
    Auth::guard('geinin')->logout();

    return redirect('/')->with('logout', 'ログアウトしました');
  }
}
