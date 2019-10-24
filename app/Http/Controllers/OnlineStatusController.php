<?php

namespace App\Http\Controllers;
use App\OnlineStatus;

use Illuminate\Http\Request;

class OnlineStatusController extends Controller
{
  public function index()
  {
      return OnlineStatus::all();
  }

  public function store(Request $request)
  {
      $onlineStatus = OnlineStatus::create($request->all());

      return response()->json($onlineStatus,201);
  }

  public function show(OnlineStatus $onlineStatus)
  {
      return $onlineStatus;
  }

  public function update(Request $request, OnlineStatus $onlineStatus)
  {
      $onlineStatus->update($request->all());

      return response()->json($onlineStatus,200);
  }

  public function delete(OnlineStatus $onlineStatus)
  {
      $onlineStatus->delete();

      return response()->json(null,204);
  }
}
