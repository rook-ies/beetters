<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppProductivityType;
use Illuminate\Support\Facades\Auth;
use Validator;

class AppProductivityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['success'=>'true','data'=>AppProductivityType::all()],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $AppProductivity = AppProductivityType::create($request->all());

        return response()->json(['success'=>'true','data'=>$AppProductivity],201);
    }

    public function show(AppProductivityType $AppProductivity)
    {
        return response()->json(['success'=>'true','data'=>$AppProductivity],200);
    }

    public function update(Request $request, AppProductivityType $AppProductivity)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $AppProductivity->update($request->all());

        return response()->json(['success'=>'true','data'=>$AppProductivity],200);
    }

    public function destroy(AppProductivityType $AppProductivity)
    {
        $AppProductivity->delete();

        return response()->json(null,204);
    }
}
