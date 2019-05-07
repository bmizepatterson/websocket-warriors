<?php

use App\Events\UserScoreUpdated;
use Illuminate\Http\Request;

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

Route::view('/', 'app');

Route::post('/app', function(Request $request) {
    event(new UserScoreUpdated($request->user, $request->score));
});

Route::fallback(function () {
    return redirect('/');
});
