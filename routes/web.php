<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/', 'GeininController@index');
//新規登録
Route::get('/register', 'GeininController@register')->name('register');
//マッチング
Route::post('/show', 'GeininController@add');
Route::get('/show', 'GeininController@show')->middleware('auth:geinin');
Route::patch('/show', 'FavoriteController@showRegister');
Route::delete('/show', 'FavoriteController@showDelete');
//認証
Route::get('/login', 'AuthController@getAuth')->name('login');
Route::post('/login', 'AuthController@postAuth');
Route::get('/logout', 'AuthController@logout');
//検索画面
Route::get('/search', 'SearchController@search');
Route::patch('/search', 'FavoriteController@register')->middleware('auth:geinin');
Route::delete('/search', 'FavoriteController@delete')->middleware('auth:geinin');
//イベント
Route::get('/event', function () {
    $auth = Auth::guard('geinin')->check();
    return view('matching.event', ['auth' => $auth]);
});
//プロフィール
Route::get('/profile', 'ProfileController@profile')->middleware('auth:geinin');
Route::post('/profile', 'ProfileController@store');
Route::get('/profile/edit', 'ProfileController@edit')->middleware('auth:geinin');
Route::post('/profile/edit', 'ProfileController@reregistar');
//メッセージ送信
Route::get('/message/{id}', 'MessageController@message')->middleware('auth:geinin')->name('message');
Route::post('/message/{id}', 'MessageController@submit');
//メッセージ
Route::get('/messagebox', 'MessageController@receive')->middleware('auth:geinin');
Route::get('/profile/{id}', 'ProfileController@show');
//お気に入り
Route::get('/favorite', 'FavoriteController@list')->middleware('auth:geinin');
Route::delete('/favorite', 'FavoriteController@listDelete');
//登録情報
Route::get('/account', 'AccountController@index')->middleware('auth:geinin');
Route::post('/account', 'AccountController@post');
Route::delete('/account', 'AccountController@delete');
//CSV　download
Route::get('/csv', 'CsvController@index');
Route::get('/csv/download', 'CsvController@download');
