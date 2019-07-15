<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Footprint extends Model
{
    public function sawGeinin()
    {
      return $this->belongsTo('App\Geinin', 'saw_id');
    }
}
