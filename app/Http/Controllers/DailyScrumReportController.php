<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $dailyScrumReport = DailyScrumReport::create($request->all());

        return response()->json($dailyScrumReport, 201);
    }

    public function update(Request $request, DailyScrumReport $dailyScrumReport)
    {
        $dailyScrumReport->update($request->all());

        return response()->json($dailyScrumReport, 200);
    }

    public function delete(DailyScrumReport $dailyScrumReport)
    {
        $dailyScrumReport->delete();

        return response()->json(null, 204);
    }
}
