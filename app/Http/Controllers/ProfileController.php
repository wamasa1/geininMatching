<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  public function profile ()
  {
    // 認証済みユーザーの取得
    $geinin = Auth::guard('geinin')->user();

    return view('matching.profile', ['geinin' => $geinin]);
  }

  public function store (ProfileRequest $request)
  {
    $geinin = Auth::guard('geinin')->user();
    //画像アップロード
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
