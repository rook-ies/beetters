<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApplicationTrackingHistory;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApplicationTrackingHistoryController extends Controller
{
  public function index()
  {
      return response()->json(['success'=>'true','data'=>ApplicationTrackingHistory::all()],200);
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'id_tracking_history' => 'required',
          'id_application' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $applicationTrackingHistory = ApplicationTrackingHistory::create($request->all());

      return response()->json(['success'=>'true','data'=>$applicationTrackingHistory],201);
  }

  public function show(ApplicationTrackingHistory $applicationTrackingHistory)
  {
      return response()->json(['success'=>'true','data'=>$applicationTrackingHistory],200);
  }

  public function update(Request $request, ApplicationTrackingHistory $applicationTrackingHistory)
  {
      $validator = Validator::make($request->all(), [
          'id_tracking_history' => 'required',
          'id_application' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $applicationTrackingHistory->update($request->all());

      return response()->json(['success'=>'true','data'=>$applicationTrackingHistory],200);
  }

  public function delete(ApplicationTrackingHistory $applicationTrackingHistory)
  {
      $applicationTrackingHistory->delete();

      return response()->json(['success'=>'true','message'=>'successfully delete'],200);
  }
}
