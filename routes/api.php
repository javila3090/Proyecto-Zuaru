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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('timestamp', 'TimeController@index');
Route::get('posts', 'PostController@index');
Route::post('post', 'PostController@store');
Route::put('posts/{post}', 'PostController@update');
Route::get('user/{user_id}/posts', 'PostController@show');
Route::get('user/{user_id}/jugar', 'GameController@play');
Route::get('leaderboard', 'GameController@leaderBoard');
Route::post('usersave', 'UserController@storeConfig');
Route::get('user/{user_id}/userload', 'UserController@listConfigs');
Route::delete('truncate/all', 'UtilityController@truncateAll');
