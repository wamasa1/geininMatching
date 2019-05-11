<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Geinin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MatchingController extends Controller
{
  public function index (Request $request)
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

    if (!empty($genreEn))
    {
      $geinins = Geinin::where('genre', $genreJa);

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

      $geinins = $geinins->paginate(4);
    } else {
      $geinins = Geinin::paginate(4);
    }

    return view('matching.search', [
      'geinins' => $geinins,
      'genre' => $genreEn,
      'role' => $roleEn,
      'creater' => $createrEn,
      'target' => $targetEn,
    ]);
  }

  public function profile ()
  {
    // 認証済みユーザーの取得
    $geinin = Auth::guard('geinin')->user();

    return view('matching.profile', ['geinin' => $geinin]);
  }

  public function store (ProfileRequest $request)
  {
    $geinin = Auth::guard('geinin')->user();

    $originalImg = $request->image;
    if ($originalImg->isValid())
    {
      $filePath = $originalImg->storeAs('public/images', $geinin->id . '.jpg');
      $geinin->image = str_replace('public/', '', $filePath);
      $geinin->save();
    }

    return redirect('/profile')->with('success', '画像をアップロードしました！');
  }

}
