<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Geinin extends Authenticatable
{
  protected $guarded = array('id');
}
