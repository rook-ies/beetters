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
Route::get('test','API\UserController@testServer');
Route::group(['middleware' => 'auth:api'], function(){

    Route::post('logout', 'API\UserController@logout');
    Route::get('user', 'API\UserController@user');

    Route::get('user-ctt-attribute', 'UserCTTAttributeController@index');
    Route::get('user-ctt-attribute/{userCTTAttribute}', 'UserCTTAttributeController@show');
    Route::post('user-ctt-attribute', 'UserCTTAttributeController@store');
    Route::put('user-ctt-attribute/{userCTTAttribute}', 'UserCTTAttributeController@update');
    Route::delete('user-ctt-attribute/{userCTTAttribute}', 'UserCTTAttributeController@delete');

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

    Route::get('application-role', 'ApplicationRoleController@index');
    Route::get('application-role/{applicationRole}', 'ApplicationRoleController@show');
    Route::post('application-role', 'ApplicationRoleController@store');
    Route::put('application-role/{applicationRole}', 'ApplicationRoleController@update');
    Route::delete('application-role/{ApplicationRole}', 'ApplicationRoleController@delete');

    Route::get('obstacle', 'ObstacleController@index');
    Route::get('obstacle/{obstacle}', 'ObstacleController@show');
    Route::post('obstacle', 'ObstacleController@store');
    Route::put('obstacle/{obstacle}', 'ObstacleController@update');
    Route::delete('obstacle/{obstacle}', 'ObstacleController@delete');

    Route::get('daily-scrum-report', 'DailyScrumReportController@index');
    Route::get('daily-scrum-report/{dailyScrumReport}', 'DailyScrumReportController@show');
    Route::post('daily-scrum-report', 'DailyScrumReportController@store');
    Route::put('daily-scrum-report/{dailyScrumReport}', 'DailyScrumReportController@update');
    Route::delete('daily-scrum-report/{dailyScrumReport}', 'DailyScrumReportController@delete');
    Route::post('daily-scrum-report/check','DailyScrumReportController@check');
    Route::post('daily-scrum-report/list','DailyScrumReportController@list');

    Route::get('app-productivity-type', 'AppProductivityTypeController@index');
    Route::get('app-productivity-type/{AppProductivity}', 'AppProductivityTypeController@show');
    Route::post('app-productivity-type', 'AppProductivityTypeController@store');
    Route::put('app-productivity-type/{AppProductivity}', 'AppProductivityTypeController@update');
    Route::delete('app-productivity-type/{AppProductivity}', 'AppProductivityTypeController@destroy');

    Route::get('team', 'TeamController@index');
    Route::get('team/{team}', 'TeamController@show');
    Route::post('team', 'TeamController@store');
    Route::put('team/{team}', 'TeamController@update');
    Route::delete('team/{team}', 'TeamController@delete');
    Route::post('team/join', 'TeamController@join');
    Route::post('team/team-list','TeamController@teamList');
    Route::post('team/member','TeamController@member');
    Route::get('team/test','TeamController@test');

    Route::get('user-team', 'UserTeamController@index');
    Route::get('user-team/{userTeam}', 'UserTeamController@show');
    Route::post('user-team', 'UserTeamController@store');
    Route::put('user-team/{userTeam}', 'UserTeamController@update');
    Route::delete('user-team/{userTeam}', 'UserTeamController@delete');

    Route::get('poke', 'PokeController@index');
    Route::get('poke/{poke}', 'PokeController@show');
    Route::post('poke', 'PokeController@store');
    Route::put('poke/{poke}', 'PokeController@update');
    Route::delete('poke/{poke}', 'PokeController@delete');

    Route::get('role', 'RoleController@index');
    Route::get('role/{role}', 'RoleController@show');
    Route::post('role', 'RoleController@store');
    Route::put('role/{role}', 'RoleController@update');
    Route::delete('role/{role}', 'RoleController@delete');

    Route::get('daily-tracking-report', 'DailyTrackingReportController@index');
    Route::get('daily-tracking-report/{dailyTrackingReport}', 'DailyTrackingReportController@show');
    Route::post('daily-tracking-report', 'DailyTrackingReportController@store');
    Route::put('daily-tracking-report/{dailyTrackingReport}', 'DailyTrackingReportController@update');
    Route::delete('daily-tracking-report/{dailyTrackingReport}', 'DailyTrackingReportController@delete');
});
