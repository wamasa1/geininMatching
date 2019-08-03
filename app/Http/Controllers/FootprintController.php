<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Footprint;

class FootprintController extends Controller
{
    public function index()
    {
        $auth_id = Auth::guard('geinin')->id();
        $footprints = Footprint::where('be_seen_id', $auth_id)->orderBy('created_at', 'desc')->get();

        return view('matching.footprint', ['footprints' => $footprints]);
    }
}
