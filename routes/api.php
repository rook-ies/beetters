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

    Route::post('insert','DailyTrackingReportController@insert');
    Route::post('logout', 'API\UserController@logout');
    Route::get('user', 'API\UserController@user');

    Route::post('application-tracking-history/data', 'ApplicationTrackingHistoryController@acceptRespones');

    Route::post('daily-scrum-report', 'DailyScrumReportController@store');
    Route::post('daily-scrum-report/check','DailyScrumReportController@check');
    Route::post('daily-scrum-report/list','DailyScrumReportController@list');
    Route::post('daily-scrum-report/complete','DailyScrumReportController@complete');

    Route::get('team/{team}', 'TeamController@show');
    Route::post('team', 'TeamController@store');
    Route::put('team/{team}', 'TeamController@update');
    Route::delete('team/{team}', 'TeamController@delete');
    Route::post('team/join', 'TeamController@join');
    Route::post('team/team-list','TeamController@teamList');
    Route::post('team/member','TeamController@member');
    Route::post('team/kick','TeamController@kick');

    Route::get('poke/{poke}', 'PokeController@show');
    Route::post('poke', 'PokeController@store');

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
    Route::post('daily-tracking-report/overal-per-user', 'DailyTrackingReportController@overalPerUser');
    Route::post('daily-tracking-report/overal-per-user-id', 'DailyTrackingReportController@overalPerUserId');
    Route::post('daily-tracking-report/overal-per-user-team', 'DailyTrackingReportController@overalPerUserTeam');
    Route::post('daily-tracking-report/history-per-user', 'DailyTrackingReportController@historyPerUser');
    Route::post('daily-tracking-report/history-per-team', 'DailyTrackingReportController@historyPerTeam');

    Route::post('daily-tracking-report/overal-per-member-team', 'DailyTrackingReportController@overalPerMemberTeam');
    Route::post('daily-tracking-report/reward-per-user', 'DailyTrackingReportController@rewardPerUser');
    Route::post('daily-tracking-report/reward-table-per-team', 'DailyTrackingReportController@rewardTablePerTeam');
});
