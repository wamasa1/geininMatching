<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use App\Message;

class Geinin extends Authenticatable
{
    protected $guarded = array('id');

    //Messageとのリレーション
    public function messageReceiver()
    {
        return $this->hasMany('App\Message', 'receiver_id');
    }
    public function messageSender()
    {
        return $this->hasOne('App\Message', 'sender_id');
    }

    //Favoriteとのリレーション
    public function favoriteFrom()
    {
        return $this->hasMany('App\Favorite', 'favoriteFrom_id');
    }
    public function favoriteTo()
    {
        return $this->hasMany('App\Favorite', 'favoriteTo_id');
    }
    //検索項目ごとに使う
    public function scopeMatching($query, $search_target, $search_item_ja)
    {
        $return_data = $query->where(function ($query) use ($search_target, $search_item_ja) {
            $query->where($search_target, $search_item_ja[0]);
            for ($i = 1; $i < count($search_item_ja); $i++) {
                $query->orWhere($search_target, $search_item_ja[$i]);
            }
        });

        return $return_data;
    }
}
