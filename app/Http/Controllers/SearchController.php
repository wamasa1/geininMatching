<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geinin;
use App\Favorite;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
  public function search (Request $request)
  {
    //$request->activity_placeを変換
    $activity_place_En = $request->activity_place;
    $activity_place_Ja = null;
    if ($activity_place_En != null) {
      $activity_place_count = count($activity_place_En);
      for ($i=0; $i<$activity_place_count; $i++) {
        switch ($activity_place_En[$i]) {
          case 'tokyo':
            $activity_place_Ja[$i] = '東京';
            break;
          case 'osaka':
            $activity_place_Ja[$i] = '大阪';
            break;
          case 'fukuoka':
            $activity_place_Ja[$i] = '福岡';
            break;
          case 'sendai':
            $activity_place_Ja[$i] = '仙台';
            break;
          case 'sapporo':
            $activity_place_Ja[$i] = '札幌';
            break;
          case 'okinawa':
            $activity_place_Ja[$i] = '沖縄';
            break;
        }
      }
    }
    //$request->genreを変換
    $genre_En = $request->genre;
    $genre_Ja = null;
    if ($genre_En != null) {
      $genre_count = count($genre_En);
      for ($i=0; $i<$genre_count; $i++) {
        switch ($genre_En[$i]) {
          case 'manzai':
            $genre_Ja[$i] = '漫才';
            break;
          case 'konto':
            $genre_Ja[$i] = 'コント';
            break;
          case 'both':
            $genre_Ja[$i] = '両方';
            break;
        }
      }
    }
    //$request->roleを変換
    $role_En = $request->role;
    $role_Ja = null;
    if ($role_En != null) {
      $role_count = count($role_En);
      for ($i=0; $i<$role_count; $i++) {
        switch ($role_En[$i]) {
          case 'boke':
            $role_Ja[$i] = 'ボケ';
            break;
          case 'tukkomi':
            $role_Ja[$i] = 'ツッコミ';
            break;
          case 'boke_tukkomi':
            $role_Ja[$i] = 'こだわらない';
            break;
        }
      }
    }
    //$request->createrを変換
    $creater_En = $request->creater;
    $creater_Ja = null;
    if ($creater_En != null) {
      $creater_count = count($creater_En);
      for ($i=0; $i<$creater_count; $i++) {
        switch ($creater_En[$i]) {
          case 'me':
            $creater_Ja[$i] = '自分が作る';
            break;
          case 'together':
            $creater_Ja[$i] = '一緒に作りたい';
            break;
          case 'you':
            $creater_Ja[$i] = '相方に作ってほしい';
            break;
        }
      }
    }
    //$request->targetを変換
    $target_En = $request->target;
    $target_Ja = null;
    if ($target_En != null) {
      $target_count = count($target_En);
      for ($i=0; $i<$target_count; $i++) {
        switch ($target_En[$i]) {
          case 'golden':
            $target_Ja[$i] = 'ゴールデンで冠番組を持つ';
            break;
          case 'midnight':
            $target_Ja[$i] = '深夜で面白い番組がしたい';
            break;
          case 'theater':
            $target_Ja[$i] = 'テレビより舞台で活躍したい';
            break;
        }
      }
    }
    //全件数
    $auth_id = Auth::guard('geinin')->id();
    $geinins = Geinin::where('id', '!=', $auth_id);
    $allCount = $geinins->count();
    //活動場所の条件適合
    if ($activity_place_En != null)
    { 
      $geinins = $geinins->where(function($query) use($activity_place_Ja, $activity_place_count){
        $query->where('activity_place', $activity_place_Ja[0]);
        for ($i=1; $i<$activity_place_count; $i++) {
          $query->orWhere('activity_place', $activity_place_Ja[$i]);
        }
      });
    }
    //ジャンルの条件適合
    if ($genre_En != null)
    { 
      $geinins = $geinins->where(function($query) use($genre_Ja, $genre_count){
        $query->where('genre', $genre_Ja[0]);
        for ($i=1; $i<$genre_count; $i++) {
          $query->orWhere('genre', $genre_Ja[$i]);
        }
      });
    }
    //役割の条件適合
    if ($role_En != null)
    { 
      $geinins = $geinins->where(function($query) use($role_Ja, $role_count){
        $query->where('role', $role_Ja[0]);
        for ($i=1; $i<$role_count; $i++) {
          $query->orWhere('role', $role_Ja[$i]);
        }
      });
    }
    //ネタ作りの条件適合
    if ($creater_En != null)
    { 
      $geinins = $geinins->where(function($query) use($creater_Ja, $creater_count){
        $query->where('creater', $creater_Ja[0]);
        for ($i=1; $i<$creater_count; $i++) {
          $query->orWhere('creater', $creater_Ja[$i]);
        }
      });
    }
    //目標の条件適合
    if ($target_En != null)
    { 
      $geinins = $geinins->where(function($query) use($target_Ja, $target_count){
        $query->where('target', $target_Ja[0]);
        for ($i=1; $i<$target_count; $i++) {
          $query->orWhere('target', $target_Ja[$i]);
        }
      });
    }
    //画像がある
    if ($request->image_upload) {
      $geinins = $geinins->where('image', '!=', null);
    }
    //認証関連
    $auth = Auth::guard('geinin')->check();
    $auth_geinin = Auth::guard('geinin')->user();

    //ログインユーザー限定項目
    $no_age_message = null;
    $guest_message = null;
    if ($auth) {
      //自分の年齢±３才
      if ($request->three_age) {
        $auth_age = $auth_geinin->age;
        if ($auth_age != null) {
          $geinins = $geinins->whereBetween('age',[$auth_age-3, $auth_age+3]);
        } else {
          $no_age_message = '年齢が未登録のため、「自分の年齢±３才」にフィルタリングされていません';
        }
      }
      //お気に入り登録済み芸人除く
      if ($request->except_favorite) {
        $favorites = Favorite::where('favoriteFrom_id', $auth_id)->get();
        foreach ($favorites as $favorite) {
          $geinins = $geinins->where('id', '!=', $favorite->favoriteTo_id);
        }
      }
    } elseif ($request->three_age || $request->except_favorite) {
      $guest_message = 'ログインしていないため、ログイン限定項目は機能していません';
    }
    
    //キーワード検索
    $keyword = $request->keyword;
    if ($keyword != null) {
      $keyword = mb_convert_kana($keyword, 's'); //全角スペースを半角に変換
      $keyword_array = preg_split("/[\s]+/", $keyword); //半角スペースで区切られた文字列を配列化
      $keyword_count = count($keyword_array);
      for ($i=0; $i<$keyword_count; $i++) {
        $geinins = $geinins->where(function($query) use($keyword_array, $i){
          $query->where('user', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('age', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('activity_place', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('genre', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('role', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('creater', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('target', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('monomane', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('favorite_geinin', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('favorite_neta', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('favorite_tv_program', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('laughing_event', 'like', '%'.$keyword_array[$i].'%')
                ->orWhere('self_introduce', 'like', '%'.$keyword_array[$i].'%');
        });
      }
    }
    //検索適合件数
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
        $geinins = $geinins->whereNotNull('age')->orderBy('age', 'asc');
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
