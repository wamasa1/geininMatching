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
  public function index()
  {
    // お気に入り登録者数上位５名を取得
    $geinins = Geinin::orderby('favorite_count', 'desc')->take(5)->get();

    $auth = Auth::guard('geinin')->check();
    return view('matching.index', [
      'geinins' => $geinins,
      'auth' => $auth
    ]);
  }

  public function register()
  {
    if(Auth::guard('geinin')->check()){
      return redirect('/show')->with('already_register', 'もうすでに登録されています');
    }else{
      return view('geinin.register');
    }
  }

  public function add(GeininRequest $request)
  {
    $auth_geinin = new Geinin;
    $form = $request->all();
    $form = array_add($form, 'favorite_count', 0);
    unset($form['__token']);
    $form['password'] = Hash::make($form['password']);
    $auth_geinin->fill($form)->save();
    Auth::guard('geinin')->login($auth_geinin);

    $auth_id = $auth_geinin->id;

    // roleのMatching
    $role = $auth_geinin->role;
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
    $creater = $auth_geinin->creater;
    switch ($creater) {
      case '自分が作る':
        $creater = '相方に作ってほしい';
        break;
      case '相方に作ってほしい':
        $creater = '自分が作る';
        break;
    }
    
    // マッチング率100%
    $partners = Geinin::where('id', '!=', $auth_id)
      ->where('activity_place', $auth_geinin->activity_place)
      ->where('genre', $auth_geinin->genre)
      ->when($role_boolean, function ($query) use ($role) {
        return $query->where('role', '!=', $role);
      })
      ->where('creater', $creater)
      ->where('target', $auth_geinin->target)
      ->inRandomOrder()->get();

    //マッチング率80%
    $eighty_partners = Geinin::where('id', '!=', $auth_id)
      ->where('activity_place', $auth_geinin->activity_place)
      ->where('genre', $auth_geinin->genre)
      ->when($role_boolean, function ($query) use ($role) {
          return $query->where('role', '!=', $role);
        })
      ->where('creater', $creater)
      ->where('target', '!=', $auth_geinin->target)
      ->inRandomOrder()->get();

    //マッチング率60%
    $sixty_partners = Geinin::where('id', '!=', $auth_id)
      ->where('activity_place', $auth_geinin->activity_place)
      ->where('genre', $auth_geinin->genre)
      ->when($role_boolean, function ($query) use ($role) {
          return $query->where('role', '!=', $role);
        })
      ->where('creater', '!=', $creater)
      ->where('target', '!=', $auth_geinin->target)
      ->inRandomOrder()->get();

    return view('matching.show', [
      'partners' => $partners,
      'eighty_partners' => $eighty_partners,
      'sixty_partners' => $sixty_partners,
      'auth_geinin' => $auth_geinin
    ]);
  }

  
  public function show()
  {
    $auth_geinin = Auth::guard('geinin')->user();
    $auth_id = $auth_geinin->id;

    // roleのMatching
    $role = $auth_geinin->role;
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
    $creater = $auth_geinin->creater;
    switch ($creater) {
      case '自分が作る':
        $creater = '相方に作ってほしい';
        break;
      case '相方に作ってほしい':
        $creater = '自分が作る';
        break;
    }
    // マッチング率100%
    $partners = Geinin::where('id', '!=', $auth_id)
      ->where('activity_place', $auth_geinin->activity_place)
      ->where('genre', $auth_geinin->genre)
      ->when($role_boolean, function ($query) use ($role) {
        return $query->where('role', '!=', $role);
      })
      ->where('creater', $creater)
      ->where('target', $auth_geinin->target)
      ->inRandomOrder()->get();

    //マッチング率80%
    $eighty_partners = Geinin::where('id', '!=', $auth_id)
      ->where('activity_place', $auth_geinin->activity_place)
      ->where('genre', $auth_geinin->genre)
      ->when($role_boolean, function ($query) use ($role) {
          return $query->where('role', '!=', $role);
        })
      ->where('creater', $creater)
      ->where('target', '!=', $auth_geinin->target)
      ->inRandomOrder()->get();

    //マッチング率60%
    $sixty_partners = Geinin::where('id', '!=', $auth_id)
      ->where('activity_place', $auth_geinin->activity_place)
      ->where('genre', $auth_geinin->genre)
      ->when($role_boolean, function ($query) use ($role) {
          return $query->where('role', '!=', $role);
        })
      ->where('creater', '!=', $creater)
      ->where('target', '!=', $auth_geinin->target)
      ->inRandomOrder()->get();

    return view('matching.show', [
      'partners' => $partners,
      'eighty_partners' => $eighty_partners,
      'sixty_partners' => $sixty_partners,
      'auth_geinin' => $auth_geinin
    ]);
  }
}
