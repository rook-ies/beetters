<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\DailyTrackingReport;
class DailyTrackingReportController extends Controller
{
    public function index()
    {
        return response()->json(['success'=>'true','data'=>DailyTrackingReport::all()],200);
    }

    public function show(DailyTrackingReport $dailyTrackingReport)
    {
        return response()->json(['success'=>'true','data'=>$dailyTrackingReport],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productive_value' => 'required',
            'netral_value' => 'required',
            'not_productive_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $dailyTrackingReport = new DailyTrackingReport;
        $dailyTrackingReport->id_user = Auth::guard('api')->id();
        $dailyTrackingReport->productive_value = $request->productive_value;
        $dailyTrackingReport->netral_value = $request->netral_value;
        $dailyTrackingReport->not_productive_value = $request->not_productive_value;
        $dailyTrackingReport->save();

        return response()->json(['success'=>'true','data'=>$dailyTrackingReport],201);
    }

    public function update(Request $request, DailyTrackingReport $dailyTrackingReport)
    {
        $validator = Validator::make($request->all(), [
            'productive_value' => 'required',
            'netral_value' => 'required',
            'not_productive_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $dailyTrackingReport->update($request->all());

        return response()->json(['success'=>'true','data'=>$dailyTrackingReport],200);
    }

    public function delete(DailyTrackingReport $dailyTrackingReport)
    {
        $dailyTrackingReport->delete();

        return response()->json(['success'=>'true','message'=>'successfully delete'],200);
    }
}
