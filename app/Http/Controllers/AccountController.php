<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\AccountDeleteRequest;
use App\Geinin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view('matching.account');
    }

    public function post(PasswordChangeRequest $request)
    {
        $geinin = Auth::guard('geinin')->user();
        //テストユーザー
        if ($geinin->user == '松本紳助（テスト）') {
            return redirect('/account')->with('test_user', 'テストユーザーであるため、パスワードは変更できません');
        }
        //照合後、パスワード変更
        if (
            $geinin->email == $request->current_email &&
            Hash::check($request->current_password, $geinin->password)
        ) {
            $geinin->password = Hash::make($request->new_password);
            $geinin->save();
            return redirect('/account')->with('password_success', 'パスワードを変更しました');
        } else {
            return redirect('/account')->with('password_failure', '現在のメールアドレス又はパスワードが異なるため、変更できませんでした');
        }
    }

    public function delete(AccountDeleteRequest $request)
    {
        $geinin = Auth::guard('geinin')->user();
        //テストユーザー
        if ($geinin->user == '松本紳助（テスト）') {
            return redirect('/account')->with('test_user', 'テストユーザーであるため、アカウントは削除できません');
        }
        //照合後、アカウント削除
        if (
            $geinin->email == $request->current_email_del &&
            Hash::check($request->current_password_del, $geinin->password)
        ) {
            $geinin->delete();
            return redirect('/')->with('account_delete', 'アカウントが削除されました');
        } else {
            return redirect('/account')->with('del_failure', '現在のメールアドレス又はパスワードが異なるため、削除できませんでした');
        }
    }
}
