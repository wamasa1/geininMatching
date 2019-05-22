<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\Geinin;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function register (Request $request)
    { //お気に入り登録
      $favorite = new Favorite;
      $favorite->favoriteTo_id = $request->favoriteTo_id;
      $favorite->favoriteFrom_id = Auth::guard('geinin')->id();
      $favorite->save();

      $geinin = Geinin::findOrFail($request->favoriteTo_id);

      return redirect('/search')
        ->with('favorite_success', $geinin->user .'さんをお気に入り登録しました');
    }

    public function list ()
    {
      $id = Auth::guard('geinin')->id();
      $favorites = Favorite::where('favoriteFrom_id', $id)->get();
      
      return view('matching.favorite', ['favorites' => $favorites]);
    }
}
