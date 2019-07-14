<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Geinin;

class ProfileController extends Controller
{
  public function profile()
  {
    // 認証済みユーザーの取得
    $geinin = Auth::guard('geinin')->user();

    return view('matching.profile', ['geinin' => $geinin]);
  }

  public function store(ProfileRequest $request)
  {
    $geinin = Auth::guard('geinin')->user();
    //s3に画像保存
    $file = $request->file('image');
    $path = Storage::disk('s3')->putFileAs('/images', $file, $geinin->id . '.jpg', 'public');
    //geininテーブルにファイル名保存
    $geinin->image = $geinin->id . '.jpg';
    $geinin->save();

    return redirect('/profile')->with('image_success', '画像をアップロードしました！');
  }

  public function edit()
  {
    $geinin = Auth::guard('geinin')->user();

    return view('geinin.profile_edit', ['geinin' => $geinin]);
  }

  public function reregistar(Request $request)
  {
    $geinin = Auth::guard('geinin')->user();

    if ($request->user) {
      $geinin->user = $request->user;
    }
    $geinin->fill($request->all())->save();

    return redirect('/profile')->with('profile_success', 'プロフィールが変更されました');
  }

  public function show($id)
  {
    $geinin = Geinin::findOrFail($id);
    $auth_id = Auth::guard('geinin')->id();

    return view('geinin.profile_details', [
      'geinin' => $geinin,
      'auth_id' => $auth_id,
    ]);
  }
}
