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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', 'GeininController@index');

Route::get('/register', 'GeininController@register');
Route::post('/register', 'GeininController@add');

Route::get('/login', 'GeininController@getAuth');
Route::post('/login', 'GeininController@postAuth');
Route::get('/logout', 'GeininController@logout');

Route::get('/search', 'MatchingController@index');

Route::get('/profile', 'MatchingController@profile');
Route::post('/profile', 'MatchingController@store');
