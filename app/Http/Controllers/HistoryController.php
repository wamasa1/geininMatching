<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Footprint;


class HistoryController extends Controller
{
    public function index()
    {
        $auth_id = Auth::guard('geinin')->id();
        // 閲覧履歴は最新10件取得
        $displayed_number = 10;
        $histories = Footprint::where('saw_id', $auth_id)->orderBy('created_at', 'desc')->take($displayed_number)->get();

        return view('matching.history', ['histories' => $histories]);
    }
}
