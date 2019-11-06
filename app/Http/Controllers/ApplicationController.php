<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Application::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_app_productivity_type' => 'required',
            'name' => 'required',
            'application_file_name' => 'required',
            'application_icon' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $application = Application::create($request->all());

        return response()->json($application,201);
    }

    public function show(Application $application)
    {
        return $application;
    }

    public function update(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
            'id_app_productivity_type' => 'required',
            'name' => 'required',
            'application_file_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $application->update($request->all());

        return response()->json($application,200);
    }

    public function delete(Application $application)
    {
        $application->delete();

        return response()->json(null,204);
    }
}
