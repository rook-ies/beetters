<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obstacle;

class ObstacleController extends Controller
{

    public function index()
    {
       return Obstacle::all();
    }

    public function store(Request $request)
    {
        $obstacle = Obstacle::create($request->all());

        return response()->json($obstacle,201);
    }

    public function show(Obstacle $obstacle)
    {
        return $obstacle;
    }

    public function update(Request $request, Obstacle $obstacle)
    {
        $obstacle->update($request->all());

        return response()->json($obstacle, 200);
    }

    public function delete(Obstacle $obstacle)
    {
        $obstacle->delete();

        return response()->json(null, 204);
    }
}
