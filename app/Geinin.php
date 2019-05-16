<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use App\Message;

class Geinin extends Authenticatable
{
  protected $guarded = array('id');

  //Messageとのリレーション
  public function messageReceiver ()
  {
    return $this->hasMany('App\Message', 'receiver_id');
  }
  public function messageSender ()
  {
    return $this->hasOne('App\Message', 'sender_id');
  }
}
