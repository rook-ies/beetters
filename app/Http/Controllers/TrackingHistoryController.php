<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackingHistory;
use Illuminate\Support\Facades\Auth;
use Validator;

class TrackingHistoryController extends Controller
{

    // public function index()
    // {
    //     return response()->json(['success'=>'true','data'=>TrackingHistory::all()],200);
    // }

    // public function store(Request $request)
    // {
    //   $trackingHistory = new TrackingHistory;
    //   $trackingHistory->id_user = Auth::guard('api')->id();
    //   // $trackingHistory->start_time = $request->start_time;
    //   // $trackingHistory->end_time = $request->end_time;
    //   // $trackingHistory->duration = $request->duration;
    //   $trackingHistory->save();
    //
    //   return response()->json(['success'=>'true','data'=>$trackingHistory],201);
    // }

    // public function show(TrackingHistory $trackingHistory)
    // {
    //     return response()->json(['success'=>'true','data'=>$trackingHistory],201);
    // }

    // public function update(Request $request,TrackingHistory $trackingHistory)
    // {
    //     $trackingHistory->update($request->all());
    //     return response()->json(['success'=>'true','data'=>$trackingHistory],201);
    // }

    // public function delete(TrackingHistory $trackingHistory)
    // {
    //     $trackingHistory->delete();
    //
    //     return response()->json(['success'=>'true','message'=>'successfully delete'],200);
    // }
}
