<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApplicationTrackingHistory;

class ApplicationTrackingHistoryController extends Controller
{
  public function index()
  {
      return ApplicationTrackingHistory::all();
  }

  public function store(Request $request)
  {
      $applicationTrackingHistory = ApplicationTrackingHistory::create($request->all());

      return response()->json($applicationTrackingHistory,201);
  }

  public function show(ApplicationTrackingHistory $applicationTrackingHistory)
  {
      return $applicationTrackingHistory;
  }

  public function update(Request $request, ApplicationTrackingHistory $applicationTrackingHistory)
  {
      $applicationTrackingHistory->update($request->all());

      return response()->json($applicationTrackingHistory,200);
  }

  public function delete(ApplicationTrackingHistory $applicationTrackingHistory)
  {
      $applicationTrackingHistory->delete();

      return response()->json(null,204);
  }
}
