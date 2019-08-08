<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Footprint;

class ProfileController extends Controller
{
    public function self_profile()
    {
        //認証済みユーザーの取得
        $geinin = Auth::guard('geinin')->user();
        // 誕生日から年齢計算
        $geinin_age = Carbon::parse($geinin->birthday)->age;
        $geinin->fill(['age' => $geinin_age]);

        return view('matching.profile', ['geinin' => $geinin]);
    }

    public function store(ProfileRequest $request)
    {
        $geinin = Auth::guard('geinin')->user();
        //画像ファイル名にidを付けて、s3に保存
        $file = $request->file('image');
        Storage::disk('s3')->putFileAs('/images', $file, $geinin->id . '.jpg', 'public');
        //geininsテーブルにファイル名保存
        $geinin->image = $geinin->id . '.jpg';
        $geinin->save();

        return redirect('/profile')->with('image_success', '画像をアップロードしました！');
    }

    public function edit()
    {
        $geinin = Auth::guard('geinin')->user();
        //今年の西暦
        $this_year = Carbon::now()->year;
        //誕生日の年月日
        $birthday = Carbon::parse($geinin->birthday);
        $geinin->fill([
            'birthday_year' => $birthday->year,
            'birthday_month' => $birthday->month,
            'birthday_day' => $birthday->day,
        ]);

        return view('geinin.profile_edit', ['geinin' => $geinin, 'this_year' => $this_year]);
    }

    public function reregistar(Request $request)
    {
        $geinin = Auth::guard('geinin')->user();
        //テストユーザーの場合を省いている
        if ($request->user) {
            $geinin->user = $request->user;
        }
        // 誕生日を1985-7-15のような形式でテーブルに保存
        $birthday = $request->birthday_year . '-' . $request->birthday_month . '-' . $request->birthday_day;
        $geinin->birthday = $birthday;
        $geinin->fill($request->except('birthday_year', 'birthday_month', 'birthday_day'))->save();

        return redirect('/profile')->with('profile_success', 'プロフィールが変更されました');
    }
    //プロフィール詳細
    public function show($geinin)
    {
        // 誕生日から年齢計算
        $geinin_age = Carbon::parse($geinin->birthday)->age;
        $geinin->fill(['age' => $geinin_age]);

        if (Auth::guard('geinin')->check()) {
            $auth_id = Auth::guard('geinin')->id();
        } else {
            $guest_id = 0; //扱いやすいように、ゲストさんは、0にしとく
            $auth_id = $guest_id; 
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
