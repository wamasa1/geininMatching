<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Message extends Model
{
  protected $guarded = array('id');

  public function geininSender ()
  {
    return $this->belongsTo('App\Geinin', 'sender_id');
  }

  public function geininReceiver ()
  {
    return $this->belongsTo('App\Geinin', 'receiver_id');
  }
}
