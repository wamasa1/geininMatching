<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GeininRequest;
use App\Geinin;
use App\Favorite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GeininController extends Controller
{
    public function index ()
    {
      // お気に入り登録者数上位５名を取得
      $geinins = Geinin::orderby('favorite_count', 'desc')->take(5)->get();

      $auth = Auth::guard('geinin')->check();
      return view('matching.index', [
        'geinins' => $geinins,
        'auth' => $auth
      ]);
    }

    public function register ()
    {
      return view('geinin.register');
    }

    public function add (GeininRequest $request)
    {
      $geinin = new Geinin;
      $form = $request->all();
      $form = array_add($form, 'favorite_count', 0);
      unset($form['__token']);
      $form['password'] = Hash::make($form['password']);
      $geinin->fill($form)->save();
      Auth::guard('geinin')->login($geinin);

      $auth_id = $geinin->id;

      // roleのMatching
      $role = $geinin->role;
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
      $creater = $geinin->creater;
      switch ($creater) {
        case '自分が作る':
          $creater = '相方に作ってほしい';
          break;
        case '相方に作ってほしい':
          $creater = '自分が作る';
          break;

      }
      // Matchingデータの抽出
      $partners = Geinin::where('id', '!=', $auth_id)
        ->where('genre', $geinin->genre)
        ->when($role_boolean, function ($query) use ($role){
          return $query->where('role', '!=', $role);
        })
        ->where('creater', $creater)
        ->where('target', $geinin->target)
        ->inRandomOrder()
        ->get();

      return view('matching.show', [
        'partners' => $partners,
        'auth_id' => $auth_id
      ]);
    }

    public function show ()
    {
      $geinin = Auth::guard('geinin')->user();
      $auth_id = $geinin->id;

      // roleのMatching
      $role = $geinin->role;
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
      $creater = $geinin->creater;
      switch ($creater) {
        case '自分が作る':
          $creater = '相方に作ってほしい';
          break;
        case '相方に作ってほしい':
          $creater = '自分が作る';
          break;

      }
      // Matchingデータの抽出
      $partners = Geinin::where('id', '!=', $auth_id)
        ->where('genre', $geinin->genre)
        ->when($role_boolean, function ($query) use ($role){
          return $query->where('role', '!=', $role);
        })
        ->where('creater', $creater)
        ->where('target', $geinin->target)
        ->inRandomOrder()
        ->get();

      return view('matching.show', [
        'partners' => $partners,
        'auth_id' => $auth_id
      ]);
    }

}
