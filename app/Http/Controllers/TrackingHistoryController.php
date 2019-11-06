<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackingHistory;
use Illuminate\Support\Facades\Auth;
use Validator;

class TrackingHistoryController extends Controller
{

    public function index()
    {
        return TrackingHistory::all();
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'start_time' => 'required',
          'end_time' => 'required',
          'duration' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $trackingHistory = new TrackingHistory;
      $trackingHistory->id_user = Auth::guard('api')->id();
      $trackingHistory->start_time = $request->start_time;
      $trackingHistory->end_time = $request->end_time;
      $trackingHistory->duration = $request->duration;
      $trackingHistory->save();

        return response()->json($trackingHistory,201);
    }

    public function show(TrackingHistory $trackingHistory)
    {
        return $trackingHistory;
    }

    public function update(Request $request,TrackingHistory $trackingHistory)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $trackingHistory->update($request->all());

        return response()->json($trackingHistory,200);
    }

    public function delete(TrackingHistory $trackingHistory)
    {
        $trackingHistory->delete();

        return response()->json(null,204);
    }
}
