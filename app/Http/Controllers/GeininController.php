<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GeininRequest;
use App\Geinin;
use Illuminate\Support\Facades\Auth;

class GeininController extends Controller
{
    public function index()
    {
        // お気に入り登録者数上位５名を取得
        $favorite_top_five = 5;
        $geinins = Geinin::orderby('favorite_count', 'desc')->take($favorite_top_five)->get();

        return view('matching.index', [
            'geinins' => $geinins,
        ]);
    }

    public function register()
    {
        if (Auth::guard('geinin')->check()) {
            return redirect('/show')->with('already_register', 'もうすでに登録されています');
        } else {
            return view('geinin.register');
        }
    }

    public function add(GeininRequest $request)
    {
        //Geininテーブルにデータ保存
        $auth_geinin = new Geinin;
        $auth_geinin->new_register = $request->all(); //モデルに処理分離
        $auth_geinin->save();

        Auth::guard('geinin')->login($auth_geinin);

        //MatchingGeininクラスを使って処理を分離した
        $matching_geinin = app()->makeWith('App\Classes\MatchingGeinin', ['auth_geinin' => $auth_geinin]);

        $partners = $matching_geinin->getPartners();
        $eighty_partners = $matching_geinin->getEightyPartners();
        $sixty_partners = $matching_geinin->getSixtyPartners();

        return view('matching.show', [
            'partners' => $partners,
            'eighty_partners' => $eighty_partners,
            'sixty_partners' => $sixty_partners,
        ]);
    }

    public function show()
    {
        $auth_geinin = Auth::guard('geinin')->user();

        //MatchingGeininクラスを使って処理を分離した
        $matching_geinin = app()->makeWith('App\Classes\MatchingGeinin', ['auth_geinin' => $auth_geinin]);

        $partners = $matching_geinin->getPartners();
        $eighty_partners = $matching_geinin->getEightyPartners();
        $sixty_partners = $matching_geinin->getSixtyPartners();

        return view('matching.show', [
            'partners' => $partners,
            'eighty_partners' => $eighty_partners,
            'sixty_partners' => $sixty_partners,
        ]);
    }
}
