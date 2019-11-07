<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Str;
use App\Team;
use App\UserTeam;
class TeamController extends Controller
{
    public function index()
    {
        return response()->json(['success'=>'true','data'=>Team::all()],200);
    }

    public function show(Team $team)
    {
        return response()->json(['success'=>'true','data'=>$team],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'room_code' => 'required|unique:team,room_code',
            'room_name' => 'required',
            'business_hour_start' => 'required',
            'business_hour_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $team = new Team;
        $team->room_code = Str::random(10);
        $team->room_name = $request->room_name;
        $team->business_hour_start = $request->business_hour_start;
        $team->business_hour_end = $request->business_hour_end;
        $team->save();

        //setalah buat langsung join

        $teamUser = new UserTeam;
        $teamUser->id_team = $team->id;
        $teamUser->id_user = Auth::guard('api')->id();
        $teamUser->id_role = 1;
        $teamUser->save();

        return response()->json(['success'=>'true','data'=>$team,'data2'=>$teamUser],201);
    }

    public function update(Request $request, Team $team)
    {
        $validator = Validator::make($request->all(), [
            'room_code' => 'unique:team,room_code',
            'room_name' => 'required',
            'business_hour_start' => 'required',
            'business_hour_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        //$team->room_code = Str::random(10);
        $team->update($request->all());

        return response()->json(['success'=>'true','data'=>$team],200);
    }

    public function delete(Team $team)
    {
        $team->delete();

        return response()->json(['success'=>'true','message'=>'successfully delete'],200);
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_code' => 'required',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $room = Team::where('room_code',$request->room_code)->first();
        if($room==null){
            return response()->json(['error'=>'room not found'], 404);
        }

        $teamUser = new UserTeam;
        $teamUser->id_team = $room->id;
        $teamUser->id_user = Auth::guard('api')->id();
        $teamUser->id_role = $request->role;
        $teamUser->save();

<<<<<<< HEAD
        return response()->json(['message'=>"you have successfully joined a team"], 200);
=======
        return response()->json(['message'=>"you have successfully joined"], 401);
>>>>>>> f65cbc743d54a3f25b2f861cf52e5df382e5ca0c
    }
}
