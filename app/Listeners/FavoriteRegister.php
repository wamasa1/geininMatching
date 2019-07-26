<?php

namespace App\Listeners;

use App\Events\FavoriteRegisterClick;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Favorite;
use App\Geinin;
use Illuminate\Support\Facades\Auth;

class FavoriteRegister
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FavoriteRegisterClick  $event
     * @return void
     */
    public function handle(FavoriteRegisterClick $event)
    {
        //お気に入り登録
        $favorite = new Favorite;
        $favorite->favoriteTo_id = $event->favoriteTo_id;
        $favorite->favoriteFrom_id = Auth::guard('geinin')->id();
        $favorite->save();
        //favorite_countを１増やす
        $geinin = Geinin::findOrFail($event->favoriteTo_id);
        $geinin->favorite_count++;
        $geinin->save();
    }
}
