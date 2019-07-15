<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Geinin;
use App\Footprint;

class ProfileController extends Controller
{
  public function self_profile()
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
    //geininsテーブルにファイル名保存
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
//プロフィール詳細
  public function show($id)
  {
    $geinin = Geinin::findOrFail($id);
    if(Auth::guard('geinin')->check()){
      $auth_id = Auth::guard('geinin')->id();
    }else{
      $auth_id = 0; //ゲストさんは0
    }
    //footprintsテーブルにデータ追加
    $footprint = new Footprint();
    $footprint->saw_id = $auth_id;
    $footprint->be_seen_id = $geinin->id;
    $footprint->save();

    return view('geinin.profile_details', [
      'geinin' => $geinin,
      'auth_id' => $auth_id,
    ]);
  }
}
