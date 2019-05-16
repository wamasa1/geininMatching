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

    if (Auth::guard('geinin')->attempt($credentials)) {
          return redirect('/show');
        } else {
          return back();
        }
  }

  public function logout ()
  {
    Auth::guard('geinin')->logout();

    return redirect('/index')->with('logout', 'ログアウトしました');
  }
}
