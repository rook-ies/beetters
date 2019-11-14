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
        return Team::all();
    }

    public function show(Team $team)
    {
        return $team;
    }

    public function store(Request $request)
    {
        //$team = Team::create($request->all());
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
        return response()->json($team, 201);
    }

    public function teamList(){
     $userTeams = UserTeam::where('id_user',Auth::guard('api')->id())->get(['id_team']);
      //echo $userTeam;
      $teamArray=[];
      foreach ($userTeams as $user_team) {
          $teamArray[] = Team::where('id',$user_team->id_team)->get();
          // $teamArray[] = UserTeam::where('id_team',$user_team->id)->get();
       }
      return response()->json(['success'=>'true','data'=>$teamArray],200);
    }

    public function test(){
     //$userTeams = UserTeam::where('id_user',Auth::guard('api')->id())->get(['id_team']);
      echo 'test';


      //return response()->json(['success'=>'true','data'=>$teamArray],200);
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
        $team->room_code = Str::random(10);
        $team->update($request->all());

        return response()->json($team, 200);
    }

    public function delete(Team $team)
    {
        $team->delete();

        return response()->json(null, 204);
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_code' => 'required',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $room = Team::where('room_code',$request->room_code)->first();
        if($room==null){
            return response()->json(['error'=>'room not found'], 200);
        }
        $ada = UserTeam::where('id_user',Auth::guard('api')->id())
                        ->where('id_team', $room->id)->count();

        if($ada){
            return response()->json(['error'=>'You already joined this team'], 200);
        }

        $teamUser = new UserTeam;
        $teamUser->id_team = $room->id;
        $teamUser->id_user = Auth::guard('api')->id();
        $teamUser->id_role = $request->role;
        $teamUser->save();
      }
}
