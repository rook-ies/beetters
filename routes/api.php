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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
});

Route::get('daily-scrum-report', 'DailyScrumReportController@index');
Route::get('daily-scrum-report/{daily-scrum-report}', 'DailyScrumReportController@show');
Route::post('daily-scrum-report', 'DailyScrumReportController@store');
Route::put('daily-scrum-report/{daily-scrum-report}', 'DailyScrumReportController@update');
Route::delete('daily-scrum-report/{daily-scrum-report}', 'DailyScrumReportController@delete');

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

Route::get('chatroom-user', 'ChatroomUserController@index');
Route::get('chatroom-user/{chatroom-user}', 'ChatroomUserController@show');
Route::post('chatroom-user', 'ChatroomUserController@store');
Route::put('chatroom-user/{chatroom-user}', 'ChatroomUserController@update');
Route::delete('chatroom-user/{chatroom-user}', 'ChatroomUserController@delete');
