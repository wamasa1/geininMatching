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

//ホーム
Route::get('/', 'GeininController@home');
//新規登録
Route::get('/register', 'GeininController@registerScreen');
//マッチング
Route::post('/show', 'GeininController@registerAndShow');
Route::get('/show', 'GeininController@show')->middleware('auth:geinin');
Route::patch('/show', 'FavoriteController@showRegister');
Route::delete('/show', 'FavoriteController@showDelete');
//認証
Route::get('/login', 'AuthController@loginScreen')->name('login_screen');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
//検索画面
Route::get('/search', 'SearchController@search')->middleware('japaneseTranslate');
Route::patch('/search', 'FavoriteController@register')->middleware('auth:geinin');
Route::delete('/search', 'FavoriteController@delete')->middleware('auth:geinin');
//イベント
Route::view('/event', 'matching.event');
//プロフィール
Route::get('/profile', 'ProfileController@self_profile')->middleware('auth:geinin');
Route::post('/profile', 'ProfileController@store');
Route::get('/profile/edit', 'ProfileController@edit')->middleware('auth:geinin');
Route::post('/profile/edit', 'ProfileController@reregistar');
//プロフィール詳細
Route::get('/profile/{geinin}', 'ProfileController@show');
//あしあと
Route::get('/footprint', 'FootprintController@index')->middleware('auth:geinin');
//メッセージ送信
Route::get('/message/{geinin}', 'MessageController@submitScreen')->middleware('auth:geinin');
Route::post('/message/{geinin}', 'MessageController@submit');
//メッセージボックス
Route::get('/messagebox', 'MessageController@receive')->middleware('auth:geinin');
//お気に入り
Route::get('/favorite', 'FavoriteController@list')->middleware('auth:geinin');
Route::delete('/favorite', 'FavoriteController@listDelete');
// 閲覧履歴
Route::get('/history', 'HistoryController@index')->middleware('auth:geinin');
Route::patch('/history', 'FavoriteController@historyRegister')->middleware('auth:geinin');
Route::delete('/history', 'FavoriteController@historyDelete')->middleware('auth:geinin');
//登録情報
Route::get('/account', 'AccountController@index')->middleware('auth:geinin');
Route::post('/account', 'AccountController@passwordChange');
Route::delete('/account', 'AccountController@accountDelete');
//CSV　download
// Route::get('/csv', 'CsvController@index');
// Route::get('/csv/download', 'CsvController@download');