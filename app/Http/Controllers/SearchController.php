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
    //$request->activity_placeを英語変換
    $activity_place_Ja = $request->activity_place;
    $activity_place_En = null;
    switch ($activity_place_Ja) {
      case '東京':
        $activity_place_En = 'tokyo';
        break;
      case '大阪':
        $activity_place_En = 'osaka';
        break;
      case '福岡':
        $activity_place_En = 'fukuoka';
        break;
      case '仙台':
        $activity_place_En = 'sendai';
        break;
      case '札幌':
        $activity_place_En = 'sapporo';
        break;
      case '沖縄':
        $activity_place_En = 'okinawa';
        break;
      }
    //$request->genreを英語変換
    $genreJa = $request->genre;
    $genreEn = null;
    switch ($genreJa) {
      case '漫才':
        $genreEn = 'manzai';
        break;
      case 'コント':
        $genreEn = 'konto';
        break;
      case '両方':
        $genreEn = 'both';
        break;
      }
    //$request->roleを英語変換
    $roleJa = $request->role;
    $roleEn = null;
    switch ($roleJa) {
      case 'ボケ':
        $roleEn = 'boke';
        break;
      case 'ツッコミ':
        $roleEn = 'tukkomi';
        break;
      case 'こだわらない':
        $roleEn = 'boke_tukkomi';
        break;
      }
    //$request->createrを英語変換
    $createrJa = $request->creater;
    $createrEn = null;
    switch ($createrJa) {
      case '自分が作る':
        $createrEn = 'me';
        break;
      case '一緒に作りたい':
        $createrEn = 'together';
        break;
      case '相方に作ってほしい':
        $createrEn = 'you';
        break;
      }
    //$request->targetを日本語変換
    $targetJa = $request->target;
    $targetEn = null;
    switch ($targetJa) {
      case 'ゴールデンで冠番組を持つ':
        $targetEn = 'golden';
        break;
      case '深夜で面白い番組がしたい':
        $targetEn = 'midnight';
        break;
      case 'テレビより舞台で活躍したい':
        $targetEn = 'theater';
        break;
      }
    //全件数
    $auth_id = Auth::guard('geinin')->id();
    $geinins = Geinin::where('id', '!=', $auth_id);
    $allCount = $geinins->count();
    //検索条件適合
    if ($activity_place_Ja != '未選択' && $activity_place_Ja != null)
    {
      $geinins = $geinins->where('activity_place', $activity_place_Ja);
    }

    if ($genreJa != '未選択' && $genreJa != null)
    {
      $geinins = $geinins->where('genre', $genreJa);
    }

    if ($roleJa != '未選択' && $roleJa != null)
    {
      $geinins = $geinins->where('role', $roleJa);
    }

    if ($createrJa != '未選択' && $createrJa != null)
    {
      $geinins = $geinins->where('creater', $createrJa);
    }

    if ($targetJa != '未選択' && $targetJa != null)
    {
      $geinins = $geinins->where('target', $targetJa);
    }

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
    ]);
  }
}
