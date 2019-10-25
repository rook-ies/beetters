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

    Route::get('user-ctt-attribute', 'UserCTTAttributeController@index');
    Route::get('user-ctt-attribute/{userCTTAttribute}', 'UserCTTAttributeController@show');
    Route::post('user-ctt-attribute', 'UserCTTAttributeController@store');
    Route::put('user-ctt-attribute/{userCTTAttribute}', 'UserCTTAttributeController@update');
    Route::delete('user-ctt-attribute/{userCTTAttribute}', 'UserCTTAttributeController@delete');

    Route::get('online-status', 'OnlineStatusController@index');
    Route::get('online-status/{onlineStatus}', 'OnlineStatusController@show');
    Route::post('online-status', 'OnlineStatusController@store');
    Route::put('online-status/{onlineStatus}', 'OnlineStatusController@update');
    Route::delete('online-status/{onlineStatus}', 'OnlineStatusController@delete');

    Route::get('application-tracking-history', 'ApplicationTrackingHistoryController@index');
    Route::get('application-tracking-history/{applicationTrackingHistory}', 'ApplicationTrackingHistoryController@show');
    Route::post('application-tracking-history', 'ApplicationTrackingHistoryController@store');
    Route::put('application-tracking-history/{applicationTrackingHistory}', 'ApplicationTrackingHistoryController@update');
    Route::delete('application-tracking-history/{trackingHistory}', 'ApplicationTrackingHistoryController@delete');

    Route::get('tracking-history', 'TrackingHistoryController@index');
    Route::get('tracking-history/{trackingHistory}', 'TrackingHistoryController@show');
    Route::post('tracking-history', 'TrackingHistoryController@store');
    Route::put('tracking-history/{trackingHistory}', 'TrackingHistoryController@update');
    Route::delete('tracking-history/{trackingHistory}', 'TrackingHistoryController@delete');

    Route::get('application', 'ApplicationController@index');
    Route::get('application/{application}', 'ApplicationController@show');
    Route::post('application', 'ApplicationController@store');
    Route::put('application/{application}', 'ApplicationController@update');
    Route::delete('application/{application}', 'ApplicationController@delete');

    Route::get('obstacle', 'ObstacleController@index');
    Route::get('obstacle/{obstacle}', 'ObstacleController@show');
    Route::post('obstacle', 'ObstacleController@store');
    Route::put('obstacle/{obstacle}', 'ObstacleController@update');
    Route::delete('obstacle/{obstacle}', 'ObstacleController@delete');

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

    Route::get('daily-tracking-report', 'DailyTrackingReportController@index');
    Route::get('daily-tracking-report/{dailyTrackingReport}', 'DailyTrackingReportController@show');
    Route::post('daily-tracking-report', 'DailyTrackingReportController@store');
    Route::put('daily-tracking-report/{dailyTrackingReport}', 'DailyTrackingReportController@update');
    Route::delete('daily-tracking-report/{dailyTrackingReport}', 'DailyTrackingReportController@delete');
});
