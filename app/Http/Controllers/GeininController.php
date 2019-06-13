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
      $auth = Auth::guard('geinin')->check();
      return view('geinin.index', ['auth' => $auth]);
    }

    public function register ()
    {
      return view('geinin.register');
    }

    public function add (GeininRequest $request)
    {
      $geinin = new Geinin;
      $form = $request->all();
      unset($form['__token']);
      $form['password'] = Hash::make($form['password']); //ハッシュ化
      $geinin->fill($form)->save();
      Auth::guard('geinin')->login($geinin);

      $id = $geinin->id;

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
      $partners = Geinin::where('id', '!=', $id)
        ->where('genre', $geinin->genre)
        ->when($role_boolean, function ($query) use ($role){
          return $query->where('role', '!=', $role);
        })
        ->where('creater', $creater)
        ->where('target', $geinin->target)
        ->inRandomOrder()
        ->get();

      return view('matching.show', ['partners' => $partners]);
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
