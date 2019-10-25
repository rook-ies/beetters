<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\DailyScrumReport;
class DailyScrumReportController extends Controller
{
    public function index()
    {
        return DailyScrumReport::all();
    }

    public function show(DailyScrumReport $dailyScrumReport)
    {
        return $dailyScrumReport;
    }

    public function store(Request $request)
    {
        //$dailyScrumReport = DailyScrumReport::create($request->all());
        $validator = Validator::make($request->all(), [
            'id_chatroom' => 'required',
            'last_24_hour_activities' => 'required',
            'next_24_hour_activities' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $dailyScrumReport = new DailyScrumReport;
        $dailyScrumReport->id_user = Auth::guard('api')->id();
        $dailyScrumReport->id_chatroom = $request->id_chatroom;
        $dailyScrumReport->last_24_hour_activities = $request->last_24_hour_activities;
        $dailyScrumReport->next_24_hour_activities = $request->next_24_hour_activities;
        $dailyScrumReport->save();
        return response()->json($dailyScrumReport, 201);
    }

    public function update(Request $request, DailyScrumReport $dailyScrumReport)
    {
        $validator = Validator::make($request->all(), [
            'id_chatroom' => 'required',
            'last_24_hour_activities' => 'required',
            'next_24_hour_activities' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $dailyScrumReport->update($request->all());

        return response()->json($dailyScrumReport, 200);
    }

    public function delete(DailyScrumReport $dailyScrumReport)
    {
        $dailyScrumReport->delete();

        return response()->json(null, 204);
    }
}
