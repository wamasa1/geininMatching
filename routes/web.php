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

Route::get('/index', 'GeininController@index');

Route::get('/register', 'GeininController@register')->name('register');

Route::post('/show', 'GeininController@add');
Route::get('/show', 'GeininController@show')->middleware('auth:geinin');
Route::patch('/show', 'FavoriteController@showRegister');
Route::delete('/show', 'FavoriteController@showDelete');

Route::get('/login', 'AuthController@getAuth')->name('login');
Route::post('/login', 'AuthController@postAuth');
Route::get('/logout', 'AuthController@logout');

Route::get('/search', 'SearchController@search');
Route::patch('/search', 'FavoriteController@register')
  ->middleware('auth:geinin');
Route::delete('/search', 'FavoriteController@delete')
  ->middleware('auth:geinin');

Route::get('/profile', 'ProfileController@profile')
  ->middleware('auth:geinin');
Route::post('/profile', 'ProfileController@store');

Route::get('/message/{id}', 'MessageController@message')
  ->middleware('auth:geinin');
Route::post('/message/{id}', 'MessageController@submit');

Route::get('/messagebox', 'MessageController@receive')
  ->middleware('auth:geinin');

Route::get('/favorite', 'FavoriteController@list')
  ->middleware('auth:geinin');
Route::delete('/favorite', 'FavoriteController@listDelete');
