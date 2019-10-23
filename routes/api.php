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

Route::get('message', 'MessageController@index');
Route::get('message/{message}', 'MessageController@show');
Route::post('message', 'MessageController@store');
Route::put('message/{message}', 'MessageController@update');
Route::delete('message/{message}', 'MessageController@delete');

Route::get('app-productivity-type', 'AppProductivityTypeController@index');
Route::get('app-productivity-type/{AppProductivity}', 'AppProductivityTypeController@show');
Route::post('app-productivity-type', 'AppProductivityTypeController@store');
Route::put('app-productivity-type/{AppProductivity}', 'AppProductivityTypeController@update');
Route::delete('app-productivity-type/{AppProductivity}', 'AppProductivityTypeController@destroy');

Route::get('chatroom', 'ChatroomController@index');
Route::get('chatroom/{chatroom}', 'ChatroomController@show');
Route::post('chatroom', 'ChatroomController@store');
Route::put('chatroom/{chatroom}', 'ChatroomController@update');
Route::delete('chatroom/{chatroom}', 'ChatroomController@delete');
