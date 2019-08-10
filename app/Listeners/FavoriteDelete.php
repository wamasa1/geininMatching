<?php

namespace App\Listeners;

use App\Events\FavoriteDeleteClick;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Favorite;
use App\Geinin;
use Illuminate\Support\Facades\Auth;

class FavoriteDelete
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
     * @param  FavoriteDeleteClick  $event
     * @return void
     */
    public function handle(FavoriteDeleteClick $event)
    {
        //お気に入り登録解除
        $auth_id = Auth::guard('geinin')->id();
        Favorite::where('favoriteTo_id', $event->favoriteTo_id)
                ->where('favoriteFrom_id', $auth_id)
                ->delete();
        //favorite_countを１減らす
        $geinin = Geinin::findOrFail($event->favoriteTo_id);
        $geinin->favorite_count--;
        $geinin->save();

    }
}
