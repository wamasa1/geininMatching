<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Footprint;


class HistoryController extends Controller
{
  public function index ()
  {
    $auth_id = Auth::guard('geinin')->id();
    $histories = Footprint::where('saw_id', $auth_id)->orderBy('created_at', 'desc')->take(10)->get();

    return view('matching.history',['histories' => $histories]);
  }
}
