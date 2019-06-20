<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function getAuth (Request $request)
  {
    return view('geinin.login');
  }

  public function postAuth (Request $request)
  {
    //認証 email passwordの照合
    $credentials = $request->only('email', 'password');

    if (Auth::guard('geinin')->attempt($credentials))
    {
      $exists = session()->exists('url');
      if ($exists) {
        $intended = session('url.intended');
        return redirect($intended)->with('login', 'ログインしました');
      } else {
        return redirect('/')->with('login', 'ログインしました');
      }

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
