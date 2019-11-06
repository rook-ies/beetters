<?php

namespace App\Http\Controllers;
use App\OnlineStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class OnlineStatusController extends Controller
{
  public function index()
  {
      return OnlineStatus::all();
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'status' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $onlineStatus = OnlineStatus::create($request->all());

      return response()->json($onlineStatus,201);
  }

  public function show(OnlineStatus $onlineStatus)
  {
      return $onlineStatus;
  }

  public function update(Request $request, OnlineStatus $onlineStatus)
  {
    $validator = Validator::make($request->all(), [
        'status' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors()], 401);
    }
    
      $onlineStatus->update($request->all());

      return response()->json($onlineStatus,200);
  }

  public function delete(OnlineStatus $onlineStatus)
  {
      $onlineStatus->delete();

      return response()->json(null,204);
  }
}
