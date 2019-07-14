<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\Geinin;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
  public function register(Request $request)
  { //お気に入り登録
    $favorite = new Favorite;
    $favorite->favoriteTo_id = $request->favoriteTo_id;
    $favorite->favoriteFrom_id = Auth::guard('geinin')->id();
    $favorite->save();
    //favorite_countを１増やす
    $geinin = Geinin::findOrFail($request->favoriteTo_id);
    $geinin->favorite_count++;
    $geinin->save();

    return redirect('/search')
      ->with('favorite_success', $geinin->user . 'さんをお気に入り登録しました');
  }

  public function delete(Request $request)
  { //お気に入り登録解除
    $auth_id = Auth::guard('geinin')->id();
    $favorite = Favorite::where('favoriteTo_id', $request->favoriteTo_id)
      ->where('favoriteFrom_id', $auth_id)
      ->delete();
    //favorite_countを１減らす
    $geinin = Geinin::findOrFail($request->favoriteTo_id);
    $geinin->favorite_count--;
    $geinin->save();

    return redirect('/search')
      ->with('favorite_delete', $geinin->user . 'さんをお気に入り解除しました');
  }

  public function list()
  {
    $id = Auth::guard('geinin')->id();
    $favorites = Favorite::where('favoriteFrom_id', $id)->get();

    return view('matching.favorite', ['favorites' => $favorites]);
  }

  public function listDelete(Request $request)
  { //お気に入り登録解除
    $auth_id = Auth::guard('geinin')->id();
    $favorite = Favorite::where('favoriteTo_id', $request->favoriteTo_id)
      ->where('favoriteFrom_id', $auth_id)
      ->delete();
    //favorite_countを１減らす
    $geinin = Geinin::findOrFail($request->favoriteTo_id);
    $geinin->favorite_count--;
    $geinin->save();

    return redirect('/favorite');
  }

  public function showRegister(Request $request)
  { //お気に入り登録
    $favorite = new Favorite;
    $favorite->favoriteTo_id = $request->favoriteTo_id;
    $favorite->favoriteFrom_id = Auth::guard('geinin')->id();
    $favorite->save();
    //favorite_countを１増やす
    $geinin = Geinin::findOrFail($request->favoriteTo_id);
    $geinin->favorite_count++;
    $geinin->save();

    return redirect('/show')
      ->with('favorite_success', $geinin->user . 'さんをお気に入り登録しました');
  }

  public function showDelete(Request $request)
  { //お気に入り登録解除
    $auth_id = Auth::guard('geinin')->id();
    $favorite = Favorite::where('favoriteTo_id', $request->favoriteTo_id)
      ->where('favoriteFrom_id', $auth_id)
      ->delete();
    //favorite_countを１減らす
    $geinin = Geinin::findOrFail($request->favoriteTo_id);
    $geinin->favorite_count--;
    $geinin->save();

    return redirect('/show')
      ->with('favorite_delete', $geinin->user . 'さんをお気に入り解除しました');
  }
}
