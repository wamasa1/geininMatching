<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GeininRequest;
use App\Geinin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GeininController extends Controller
{
    public function index ()
    {
      return view('geinin.index');
    }

    public function register (Request $request)
    {
      return view('geinin.register',);
    }

    public function add (GeininRequest $request)
    {
      $geinin = new Geinin;
      $form = $request->all();
      unset($form['__token']);
      $form['password'] = Hash::make($form['password']); //ハッシュ化
      $geinin->fill($form)->save();

      // roleのMatching
      $role = $request->role;
      switch ($role) {
        case 'ボケ':
        case 'ツッコミ':
          $role_boolean = true;
          break;
        case 'こだわらない':
          $role_boolean = false;
          break;
      }
      // createrのMatching
      $creater = $request->creater;
      switch ($creater) {
        case '自分が作る':
          $creater = '相方に作ってほしい';
          break;
        case '相方に作ってほしい':
          $creater = '自分が作る';
          break;
      }
      // Matchingデータの抽出
      $partners = Geinin::where('id', '!=', $request->id)
        ->where('genre', $request->genre)
        ->when($role_boolean, function ($query) use ($role){
          return $query->where('role', '!=', $role);
        })
        ->where('creater', $creater)
        ->where('target', $request->target)
        ->get();

      return view('geinin.show', ['partners' => $partners]);
    }

    public function getAuth (Request $request)
    {
      return view('geinin.login');
    }

    public function postAuth (Request $request)
    {
      //認証 email passwordの照合
      $credentials = $request->only('email', 'password');

      if (Auth::guard('geinin')->attempt($credentials)) {
            return redirect('/profile');
          } else {
            return redirect('/login');
          }
    }

    public function logout ()
    {
      Auth::logout();

      return redirect('/index')->with('logout', 'ログアウトしました');
    }

}
