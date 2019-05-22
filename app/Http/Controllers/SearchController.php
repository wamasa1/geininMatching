<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geinin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
  public function search (Request $request)
  {
    //ジャンルを日本語変換
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
    //役割を日本語変換
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
    //ネタ作りを日本語変換
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
    //目標を日本語変換
    $targetEn = $request->target;
    $targetJa = null;
    switch ($targetEn) {
      case 'golden':
        $targetJa = 'ゴールデンで冠番組を持つ';
        break;
      case 'midnight':
        $targetJa = '深夜でもいいから、面白い番組がしたい';
        break;
      case 'theater':
        $targetJa = 'テレビよりも舞台で活躍したい';
        break;
      }
    //全件数
    $auth_id = Auth::guard('geinin')->id();
    $geinins = Geinin::where('id', '!=', $auth_id);
    $allCount = $geinins->count();
    //検索条件適合
    if (!empty($genreEn))
    {
      $geinins = Geinin::where('genre', $genreJa);
    }

    if (!empty($roleEn))
    {
      $geinins = $geinins->where('role', $roleJa);
    }

    if (!empty($createrEn))
    {
      $geinins = $geinins->where('creater', $createrJa);
    }

    if (!empty($targetEn))
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
    //認証チェック
    $auth = Auth::guard('geinin')->check();

    return view('matching.search', [
      'allCount' => $allCount,
      'hitCount' => $hitCount,
      'geinins' => $geinins,
      'auth' => $auth,
      'genre' => $genreEn,
      'role' => $roleEn,
      'creater' => $createrEn,
      'target' => $targetEn,
    ]);
  }
}
