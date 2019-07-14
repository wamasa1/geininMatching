<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
  public function geininFavoriteFrom()
  {
    return $this->belongsTo('App\Geinin', 'favoriteFrom_id');
  }

  public function geininFavoriteTo()
  {
    return $this->belongsTo('App\Geinin', 'favoriteTo_id');
  }
}
