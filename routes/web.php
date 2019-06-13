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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'GeininController@index');
//新規登録
Route::get('/register', 'GeininController@register')->name('register');
//相性の良い相方
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
Route::patch('/search', 'FavoriteController@register')
  ->middleware('auth:geinin');
Route::delete('/search', 'FavoriteController@delete')
  ->middleware('auth:geinin');
//イベント
Route::get('/event', function () {
    return view('matching.event');
})->middleware('auth:geinin');
//プロフィール
Route::get('/profile', 'ProfileController@profile')
  ->middleware('auth:geinin');
Route::post('/profile', 'ProfileController@store');
Route::get('/profile/edit', 'ProfileController@edit');
Route::post('/profile/edit', 'ProfileController@reregistar');
//メッセージ送信
Route::get('/message/{id}', 'MessageController@message')
  ->middleware('auth:geinin');
Route::post('/message/{id}', 'MessageController@submit');
//メッセージボックス
Route::get('/messagebox', 'MessageController@receive')
  ->middleware('auth:geinin');
//お気に入りリスト
Route::get('/favorite', 'FavoriteController@list')
  ->middleware('auth:geinin');
Route::delete('/favorite', 'FavoriteController@listDelete');

//CSV　download
Route::get('/csv', 'CsvController@index');
Route::get('/csv/download', 'CsvController@download');
