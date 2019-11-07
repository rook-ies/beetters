<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obstacle;
use Illuminate\Support\Facades\Auth;
use Validator;

class ObstacleController extends Controller
{

    public function index()
    {
       return response()->json(['success'=>'true','data'=>Obstacle::all()],200);
       //return Obstacle::all();
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'id_daily_scrum_report' => 'required',
          'content' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

        $obstacle = Obstacle::create($request->all());

        return response()->json(['success'=>'true','data'=>$obstacle],201);
    }

    public function show(Obstacle $obstacle)
    {
      return response()->json(['success'=>'true','data'=>$obstacle],200);
    }

    public function update(Request $request, Obstacle $obstacle)
    {
        $validator = Validator::make($request->all(), [
            'id_daily_scrum_report' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $obstacle->update($request->all());

        return response()->json(['success'=>'true','data'=>$obstacle],200);
    }

    public function delete(Obstacle $obstacle)
    {
        $obstacle->delete();

        return response()->json(null, 204);
    }
}
