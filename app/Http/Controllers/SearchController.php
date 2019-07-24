<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geinin;
use App\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    $genreEn = $request->genre;
    $genreJa = null;
    if ($genreEn != null) {
      $genre_count = count($genreEn);
      for ($i=0; $i<$genre_count; $i++) {
        switch ($genreEn[$i]) {
          case 'manzai':
            $genreJa[$i] = '漫才';
            break;
          case 'konto':
            $genreJa[$i] = 'コント';
            break;
          case 'both':
            $genreJa[$i] = '両方';
            break;
        }
      }
    }
    //$request->roleを変換
    $roleEn = $request->role;
    $roleJa = null;
    if ($roleEn != null) {
      $role_count = count($roleEn);
      for ($i=0; $i<$role_count; $i++) {
        switch ($roleEn[$i]) {
          case 'boke':
            $roleJa[$i] = 'ボケ';
            break;
          case 'tukkomi':
            $roleJa[$i] = 'ツッコミ';
            break;
          case 'boke_tukkomi':
            $roleJa[$i] = 'こだわらない';
            break;
        }
      }
    }
    //$request->createrを変換
    $createrEn = $request->creater;
    $createrJa = null;
    if ($createrEn != null) {
      $creater_count = count($createrEn);
      for ($i=0; $i<$creater_count; $i++) {
        switch ($createrEn[$i]) {
          case 'me':
            $createrJa[$i] = '自分が作る';
            break;
          case 'together':
            $createrJa[$i] = '一緒に作りたい';
            break;
          case 'you':
            $createrJa[$i] = '相方に作ってほしい';
            break;
        }
      }
    }
    //$request->targetを変換
    $targetEn = $request->target;
    $targetJa = null;
    if ($targetEn != null) {
      $target_count = count($targetEn);
      for ($i=0; $i<$target_count; $i++) {
        switch ($targetEn[$i]) {
          case 'golden':
            $targetJa[$i] = 'ゴールデンで冠番組を持つ';
            break;
          case 'midnight':
            $targetJa[$i] = '深夜で面白い番組がしたい';
            break;
          case 'theater':
            $targetJa[$i] = 'テレビより舞台で活躍したい';
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
    if ($genreEn != null)
    { 
      $geinins = $geinins->where(function($query) use($genreJa, $genre_count){
        $query->where('genre', $genreJa[0]);
        for ($i=1; $i<$genre_count; $i++) {
          $query->orWhere('genre', $genreJa[$i]);
        }
      });
    }
    //役割の条件適合
    if ($roleEn != null)
    { 
      $geinins = $geinins->where(function($query) use($roleJa, $role_count){
        $query->where('role', $roleJa[0]);
        for ($i=1; $i<$role_count; $i++) {
          $query->orWhere('role', $roleJa[$i]);
        }
      });
    }
    //ネタ作りの条件適合
    if ($createrEn != null)
    { 
      $geinins = $geinins->where(function($query) use($createrJa, $creater_count){
        $query->where('creater', $createrJa[0]);
        for ($i=1; $i<$creater_count; $i++) {
          $query->orWhere('creater', $createrJa[$i]);
        }
      });
    }
    //目標の条件適合
    if ($targetEn != null)
    { 
      $geinins = $geinins->where(function($query) use($targetJa, $target_count){
        $query->where('target', $targetJa[0]);
        for ($i=1; $i<$target_count; $i++) {
          $query->orWhere('target', $targetJa[$i]);
        }
      });
    }
    //画像がある
    if ($request->imageUpload) {
      $geinins = $geinins->where('image', '!=', null);
    }
    //認証関連
    $auth = Auth::guard('geinin')->check();
    $auth_geinin = Auth::guard('geinin')->user();

    //ログインユーザー限定項目
    $noAgeMessage = null;
    $guestMessage = null;
    if ($auth) {
      //自分の年齢±３才
      if ($request->threeAge) {
        $auth_age = $auth_geinin->age;
        if ($auth_age != null) {
          $geinins = $geinins->whereBetween('age',[$auth_age-3, $auth_age+3]);
        } else {
          $noAgeMessage = '年齢が未登録のため、「自分の年齢±３才」にフィルタリングされていません';
        }
      }
      //お気に入り登録済み芸人除く
      if ($request->exceptFavorite) {
        $favorites = Favorite::where('favoriteFrom_id', $auth_id)->get();
        foreach ($favorites as $favorite) {
          $geinins = $geinins->where('id', '!=', $favorite->favoriteTo_id);
        }
      }
    } elseif ($request->threeAge || $request->exceptFavorite) {
      $guestMessage = 'ログインしていないため、ログイン限定項目は機能していません';
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
      case 'orderFavorite':
        $geinins = $geinins->orderBy('favorite_count', 'desc');
        break;
      case 'orderRegister':
        $geinins = $geinins->latest();
        break;
      case 'orderYoung':
        $geinins = $geinins->orderBy('age', 'asc');
        break;
      case 'orderRandom':
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
      'auth' => $auth,
      'auth_geinin' => $auth_geinin,
      'activity_place' => $activity_place_En,
      'activity_place_Ja' => $activity_place_Ja,
      'genre' => $genreEn,
      'genreJa' => $genreJa,
      'role' => $roleEn,
      'roleJa' => $roleJa,
      'creater' => $createrEn,
      'createrJa' => $createrJa,
      'target' => $targetEn,
      'targetJa' => $targetJa,
      'imageUpload' => $request->imageUpload,
      'threeAge' => $request->threeAge,
      'noAgeMessage' => $noAgeMessage,
      'exceptFavorite' => $request->exceptFavorite,
      'guestMessage' => $guestMessage,
      'keyword' => $keyword,
      'order' => $request->order,
      'omikuji' => $request->omikuji,
    ]);
  }
}
