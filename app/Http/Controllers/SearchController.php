<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geinin;
use App\Favorite;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        //全件数
        $auth_id = Auth::guard('geinin')->id();
        $geinins = Geinin::where('id', '!=', $auth_id);
        $allCount = $geinins->count();

        //活動場所の条件適合
        $activity_place_En = $request->activity_place;
        $activity_place_Ja = $request->activity_place_Ja;
        if (isset($activity_place_En)) {
            $geinins = $geinins->matching('activity_place', $activity_place_Ja);
        }
        //ジャンルの条件適合
        $genre_En = $request->genre;
        $genre_Ja = $request->genre_Ja;
        if (isset($genre_En)) {
            $geinins = $geinins->matching('genre', $genre_Ja);
        }
        //役割の条件適合
        $role_En = $request->role;
        $role_Ja = $request->role_Ja;
        if (isset($role_En)) {
            $geinins = $geinins->matching('role', $role_Ja);
        }
        //ネタ作りの条件適合
        $creater_En = $request->creater;
        $creater_Ja = $request->creater_Ja;
        if (isset($creater_En)) {
            $geinins = $geinins->matching('creater', $creater_Ja);
        }
        //目標の条件適合
        $target_En = $request->target;
        $target_Ja = $request->target_Ja;
        if (isset($target_En)) {
            $geinins = $geinins->matching('target', $target_Ja);
        }
        //画像がある
        if ($request->image_upload) {
            $geinins = $geinins->where('image', '!=', null);
        }

        //認証関連
        $is_auth = Auth::guard('geinin')->check();
        $auth_geinin = Auth::guard('geinin')->user();
        //ログインユーザー限定項目
        $no_age_message = null;
        $guest_message = null;
        if ($is_auth) {
            //自分の年齢±３才
            if ($request->three_age && isset($auth_geinin->birthday)) {
                $birthday_add_three = Carbon::parse($auth_geinin->birthday)->addYear(3);
                $birthday_sub_three = Carbon::parse($auth_geinin->birthday)->subYear(3);
                $geinins = $geinins->whereBetween('birthday', [$birthday_sub_three, $birthday_add_three]);
            } elseif (empty($auth_geinin->birthday)) {
                $no_age_message = '年齢が未登録のため、「自分の年齢±３才」にフィルタリングされていません';
            }
            //お気に入り登録済み芸人除く
            if ($request->except_favorite) {
                $favorites = Favorite::where('favoriteFrom_id', $auth_id)->get();
                foreach ($favorites as $favorite) {
                    $geinins = $geinins->where('id', '!=', $favorite->favoriteTo_id);
                }
            }
        //ログインユーザー限定項目を選択したが、認証されていない場合
        } elseif ($request->three_age || $request->except_favorite) {
            $guest_message = 'ログインしていないため、ログイン限定項目は機能していません';
        }

        //キーワード検索
        $keyword = $request->keyword;
        if (isset($keyword)) {
            $keyword = mb_convert_kana($keyword, 's'); //全角スペースを半角に変換
            $keyword_array = preg_split("/[\s]+/", $keyword); //半角スペースで区切られた文字列を配列化
            for ($i = 0; $i < count($keyword_array); $i++) {
                $geinins = $geinins->where(function ($query) use ($keyword_array, $i) {
                    $search_target = ['user', 'activity_place', 'genre', 'role', 'creater', 'target', 'monomane', 'favorite_geinin', 'favorite_neta', 'favorite_tv_program', 'laughing_event', 'self_introduce'];

                    $query->where($search_target[0], 'like', '%' . $keyword_array[$i] . '%');
                    for ($j = 1; $j < count($search_target); $j++) {
                        $query->orWhere($search_target[$j], 'like', '%' . $keyword_array[$i] . '%');
                    }
                });
            }
        }

        //検索適合件数(ここの時点で$geininsの絞り込みが終わっている)
        $hitCount = $geinins->count();

        //並び替え
        switch ($request->order) {
            case 'order_favorite':
                $geinins = $geinins->orderBy('favorite_count', 'desc');
                break;
            case 'order_register':
                $geinins = $geinins->latest();
                break;
            case 'order_young':
                $geinins = $geinins->whereNotNull('birthday')->orderBy('birthday', 'desc');
                break;
            case 'order_random':
                $geinins = $geinins->inRandomOrder();
                break;
        }
        //ペジネーション
        $geinins = $geinins->paginate(4);

        //おみくじ検索
        if ($request->omikuji) {
            $geinins = Geinin::where('id', '!=', $auth_id)->inRandomOrder()->paginate(1);
            $hitCount = $geinins->count();
        }
        
        //未検索時
        if ($request->all() == null) {
            $geinins = Geinin::where('id', '!=', $auth_id)->paginate(4);
        }

        return view('matching.search', [
            'allCount' => $allCount,
            'hitCount' => $hitCount,
            'geinins' => $geinins,
            'activity_place' => $activity_place_En,
            'activity_place_Ja' => $activity_place_Ja,
            'genre' => $genre_En,
            'genre_Ja' => $genre_Ja,
            'role' => $role_En,
            'role_Ja' => $role_Ja,
            'creater' => $creater_En,
            'creater_Ja' => $creater_Ja,
            'target' => $target_En,
            'target_Ja' => $target_Ja,
            'image_upload' => $request->image_upload,
            'three_age' => $request->three_age,
            'no_age_message' => $no_age_message,
            'except_favorite' => $request->except_favorite,
            'guest_message' => $guest_message,
            'keyword' => $keyword,
            'order' => $request->order,
            'omikuji' => $request->omikuji,
        ]);
    }
}
