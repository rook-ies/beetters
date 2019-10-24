<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyTrackingReport;
class DailyTrackingReportController extends Controller
{
    public function index()
    {
        return DailyTrackingReport::all();
    }

    public function show(DailyTrackingReport $dailyTrackingReport)
    {
        return $dailyTrackingReport;
    }

    public function store(Request $request)
    {
        $dailyTrackingReport = DailyTrackingReport::create($request->all());

        return response()->json($dailyTrackingReport, 201);
    }

    public function update(Request $request, DailyTrackingReport $dailyTrackingReport)
    {
        $dailyTrackingReport->update($request->all());

        return response()->json($dailyTrackingReport, 200);
    }

    public function delete(DailyTrackingReport $dailyTrackingReport)
    {
        $dailyTrackingReport->delete();

        return response()->json(null, 204);
    }
}
