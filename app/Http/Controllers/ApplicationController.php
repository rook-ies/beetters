<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;

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
        $application = Application::create($request->all());

        return response()->json($application,201);
    }

    public function show(Application $application)
    {
        return $application;
    }

    public function update(Request $request, Application $application)
    {
        $application->update($request->all());

        return response()->json($application,200);
    }

    public function delete(Application $application)
    {
        $application->delete();

        return response()->json(null,204);
    }
}
