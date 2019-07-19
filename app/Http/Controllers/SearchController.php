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
    $activity_place_Ja = null;
    switch ($activity_place_En) {
      case 'tokyo':
        $activity_place_Ja = '東京';
        break;
      case 'osaka':
        $activity_place_Ja = '大阪';
        break;
      case 'fukuoka':
        $activity_place_Ja = '福岡';
        break;
      case 'sendai':
        $activity_place_Ja = '仙台';
        break;
      case 'sapporo':
        $activity_place_Ja = '札幌';
        break;
      case 'okinawa':
        $activity_place_Ja = '沖縄';
        break;
      }
    //$request->genreを変換
    $genreEn = $request->genre;
    $genreJa = null;
    switch ($genreEn) {
      case 'manzai':
        $genreJa = '漫才';
        break;
      case 'konto':
        $genreJa = 'コント';
        break;
      case 'both':
        $genreJa = '両方';
        break;
      }
    //$request->roleを変換
    $roleEn = $request->role;
    $roleJa = null;
    switch ($roleEn) {
      case 'boke':
        $roleJa = 'ボケ';
        break;
      case 'tukkomi':
        $roleJa = 'ツッコミ';
        break;
      case 'boke_tukkomi':
        $roleJa = 'こだわらない';
        break;
      }
    //$request->createrを変換
    $createrEn = $request->creater;
    $createrJa = null;
    switch ($createrEn) {
      case 'me':
        $createrJa = '自分が作る';
        break;
      case 'together':
        $createrJa = '一緒に作りたい';
        break;
      case 'you':
        $createrJa = '相方に作ってほしい';
        break;
      }
    //$request->targetを変換
    $targetEn = $request->target;
    $targetJa = null;
    switch ($targetEn) {
      case 'golden':
        $targetJa = 'ゴールデンで冠番組を持つ';
        break;
      case 'midnight':
        $targetJa = '深夜で面白い番組がしたい';
        break;
      case 'theater':
        $targetJa = 'テレビより舞台で活躍したい';
        break;
      }
    //全件数
    $auth_id = Auth::guard('geinin')->id();
    $geinins = Geinin::where('id', '!=', $auth_id);
    $allCount = $geinins->count();
    //検索条件適合
    if ($activity_place_En != 'no_select' && $activity_place_En != null)
    {
      $geinins = $geinins->where('activity_place', $activity_place_Ja);
    }

    if ($genreEn != 'no_select' && $genreEn != null)
    {
      $geinins = $geinins->where('genre', $genreJa);
    }

    if ($roleEn != 'no_select' && $roleEn != null)
    {
      $geinins = $geinins->where('role', $roleJa);
    }

    if ($createrEn != 'no_select' && $createrEn != null)
    {
      $geinins = $geinins->where('creater', $createrJa);
    }
    
    if ($targetEn != 'no_select' && $targetEn != null)
    {
      $geinins = $geinins->where('target', $targetJa);
    }

    //キーワード検索
    $keyword = $request->keyword;
    if ($keyword != null) {
      $geinins = $geinins->where('activity_place', 'like', '%'.$keyword.'%')
                        ->orWhere('genre', 'like', '%'.$keyword.'%')
                        ->orWhere('role', 'like', '%'.$keyword.'%')
                        ->orWhere('creater', 'like', '%'.$keyword.'%')
                        ->orWhere('target', 'like', '%'.$keyword.'%')
                        ->orWhere('self_introduce', 'like', '%'.$keyword.'%');
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
