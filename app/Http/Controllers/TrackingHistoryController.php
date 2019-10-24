<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackingHistory;

class TrackingHistoryController extends Controller
{

    public function index()
    {
        return TrackingHistory::all();
    }

    public function store(Request $request)
    {
        $trackingHistory = TrackingHistory::create($request->all());

        return response()->json($trackingHistory,201);
    }

    public function show(TrackingHistory $trackingHistory)
    {
        return $trackingHistory;
    }

    public function update(Request $request,TrackingHistory $trackingHistory)
    {
        $trackingHistory->update($request->all());

        return response()->json($trackingHistory,200);
    }

    public function delete(TrackingHistory $trackingHistory)
    {
        $trackingHistory->delete();

        return response()->json(null,204);
    }
}
