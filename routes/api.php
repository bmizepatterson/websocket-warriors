<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/play/new', 'GameController@store');
Route::get('/play/{gameCode}', 'GameController@find');
Route::put('/play/{game}', 'GameController@register');
Route::post('/play/{game}', 'GameController@play');
Route::post('/play/{game}/leave', 'GameController@leave');

Route::get('/play/{game}/messages', 'MessageController@getMessages');
Route::post('play/{game}/messages', 'MessageController@store');