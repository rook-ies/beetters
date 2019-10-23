<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppProductivityType;

class AppProductivityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return AppProductivityType::all();
    }

    public function store(Request $request)
    {
        //
        $AppProductivity = AppProductivityType::create($request->all());

        return response()->json($AppProductivity,201);
    }

    public function show(AppProductivityType $AppProductivity)
    {
        return $AppProductivity;
    }

    public function update(Request $request, AppProductivityType $AppProductivity)
    {
        $AppProductivity->update($request->all());

        return response()->json($AppProductivity,200);
    }

    public function destroy(AppProductivityType $AppProductivity)
    {
        $AppProductivity->delete();

        return response()->json(null,204);
    }
}
