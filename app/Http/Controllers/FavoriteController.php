<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\FavoriteRegisterClick;
use App\Events\FavoriteDeleteClick;
use App\Favorite;
use App\Geinin;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function register(Request $request)
    {
        event(new FavoriteRegisterClick($request->favoriteTo_id));
        $geinin = Geinin::findOrFail($request->favoriteTo_id);

        return back()->with('favorite_success', $geinin->user . 'さんをお気に入り登録しました');
    }

    public function delete(Request $request)
    {
        event(new FavoriteDeleteClick($request->favoriteTo_id));
        $geinin = Geinin::findOrFail($request->favoriteTo_id);

        return back()->with('favorite_delete', $geinin->user . 'さんをお気に入り解除しました');
    }

    public function list()
    {
        $auth_id = Auth::guard('geinin')->id();
        $favorites = Favorite::where('favoriteFrom_id', $auth_id)->get();

        return view('matching.favorite', ['favorites' => $favorites]);
    }

    public function listDelete(Request $request)
    {
        event(new FavoriteDeleteClick($request->favoriteTo_id));
        $geinin = Geinin::findOrFail($request->favoriteTo_id);

        return back()->with('favorite_delete', $geinin->user . 'さんをお気に入り解除しました');
    }

    //show画面
    public function showRegister(Request $request)
    {
        event(new FavoriteRegisterClick($request->favoriteTo_id));
        $geinin = Geinin::findOrFail($request->favoriteTo_id);

        return redirect('/show')
            ->with('favorite_success', $geinin->user . 'さんをお気に入り登録しました');
    }

    public function showDelete(Request $request)
    {
        event(new FavoriteDeleteClick($request->favoriteTo_id));
        $geinin = Geinin::findOrFail($request->favoriteTo_id);

        return back()->with('favorite_delete', $geinin->user . 'さんをお気に入り解除しました');
    }

    // history画面
    public function historyRegister(Request $request)
    {
        event(new FavoriteRegisterClick($request->favoriteTo_id));
        $geinin = Geinin::findOrFail($request->favoriteTo_id);

        return back()->with('favorite_success', $geinin->user . 'さんをお気に入り登録しました');
    }

    public function historyDelete(Request $request)
    {
        event(new FavoriteDeleteClick($request->favoriteTo_id));
        $geinin = Geinin::findOrFail($request->favoriteTo_id);

        return back()->with('favorite_delete', $geinin->user . 'さんをお気に入り解除しました');
    }
}
