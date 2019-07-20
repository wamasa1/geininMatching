<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geinin;
use App\Favorite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
  public function search (Request $request)
  {
    //$request->activity_placeを変換
    $activity_place_En = $request->activity_place;
    if ($activity_place_En != null) {
      $activity_place_count = count($activity_place_En);
      $activity_place_Ja = null;
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
    if ($genreEn != null) {
      $genre_count = count($genreEn);
      $genreJa = null;
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
    if ($roleEn != null) {
      $role_count = count($roleEn);
      $roleJa = null;
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
    if ($createrEn != null) {
      $creater_count = count($createrEn);
      $createrJa = null;
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
    if ($targetEn != null) {
      $target_count = count($targetEn);
      $targetJa = null;
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
    
    //キーワード検索
    $keyword = $request->keyword;
    if ($keyword != null) {
      $geinins = $geinins->where(function($query) use($keyword){
        $query->where('user', 'like', '%'.$keyword.'%')
              ->orWhere('activity_place', 'like', '%'.$keyword.'%')
              ->orWhere('genre', 'like', '%'.$keyword.'%')
              ->orWhere('role', 'like', '%'.$keyword.'%')
              ->orWhere('creater', 'like', '%'.$keyword.'%')
              ->orWhere('target', 'like', '%'.$keyword.'%')
              ->orWhere('self_introduce', 'like', '%'.$keyword.'%');
      });
    }

    // 検索適合件数
    $hitCount = $geinins->count();
    
    //ペジネーション
    if ($allCount != $hitCount)
    {
      $geinins = $geinins->paginate(4);
    } else {
      $geinins = Geinin::where('id', '!=', $auth_id)->paginate(4);
    }
    //認証関連
    $auth = Auth::guard('geinin')->check();
    $auth_id = Auth::guard('geinin')->id();

    return view('matching.search', [
      'allCount' => $allCount,
      'hitCount' => $hitCount,
      'geinins' => $geinins,
      'auth' => $auth,
      'auth_id' => $auth_id,
      'activity_place' => $activity_place_En,
      'genre' => $genreEn,
      'role' => $roleEn,
      'creater' => $createrEn,
      'target' => $targetEn,
      'keyword' => $keyword,
    ]);
  }
}
