<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Geinin;

class CsvController extends Controller
{
    public function index()
    {
        return view('geinin.csv');
    }

    public function download()
    {
        $users = Geinin::all()->toArray();
        $stream = fopen('php://output', 'w');
        //　文字化け回避
        stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');
        // タイトルを追加
        fputcsv($stream, ['id', 'user', 'image', 'age', 'activity_place', 'genre', 'role', 'creater', 'target', 'monomane', 'favorite_geinin', 'favorite_neta', 'favorite_tv_program', 'laughing_event', 'self_introduce', 'email', 'password', 'created_at', 'updated_at']);

        foreach ($users as $user) {
            fputcsv($stream, $user);
        }
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="geinins.csv"',
        );
        return Response::make('', 200, $headers);
    }
}
