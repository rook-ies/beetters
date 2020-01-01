<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Str;
use App\User;
use App\Team;
use App\UserTeam;
class TeamController extends Controller
{
    public function show(Team $team)
    {
        return response()->json(['success'=>'true','data'=>$team],200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_code' => 'required|unique:team,room_code',
            'room_name' => 'required',
            'business_hour_start' => 'required',
            'business_hour_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $team = Team::create($request->all());

        $teamUser = new UserTeam;
        $teamUser->id_team = $team->id;
        $teamUser->id_user = Auth::guard('api')->id();
        $teamUser->id_role = 1;
        $teamUser->save();

        return response()->json(['success'=>'true','data'=>$team,'data2'=>$teamUser],201);
    }

    public function teamList(){
     $userTeams = UserTeam::where('id_user',Auth::guard('api')->id())->get(['id_team']);

      $teamArray= array();
      $i=0;
      foreach ($userTeams as $user_team) {
          $teamArray[$i]['details'] = Team::where('id',$user_team->id_team)->get();
          $query = UserTeam::where('id_team',$user_team->id_team)->first()->id_user;

           $teamArray[$i]['manager'] = User::where('id',$query)->get();
           $i++;
       }
      return response()->json(['success'=>'true','dataTeam'=>$teamArray],200);
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
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $team->room_code = Str::random(10);
        $team->update($request->all());

        return response()->json(['success'=>'true','data'=>'$team'],200);

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
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $room = Team::where('room_code',$request->room_code)->first();
        if($room==null){
            return response()->json(['error'=>'room not found'], 200);
        }
        $ada = UserTeam::where('id_user',Auth::guard('api')->id())
                        ->where('id_team', $room->id)->count();

        if($ada){
            return response()->json(['message'=>'You already joined this team'], 200);
        }

        $teamUser = new UserTeam;
        $teamUser->id_team = $room->id;
        $teamUser->id_user = Auth::guard('api')->id();
        $teamUser->id_role = $request->role;
        $teamUser->save();

        return response()->json(['message'=>'You successfully joined this team'], 200);
      }

      public function member(Request $request)
      {
          $validator = Validator::make($request->all(), [
              'id' => 'required',
          ]);
          if ($validator->fails()) {
              return response()->json(['error'=>$validator->errors()], 200);
          }
          $userTeams = UserTeam::where('id_team',$request->id)->orderBy('id_role', 'asc')->get();
          $memberArray= array();
          $i=0;
          $j=0;
          $k=0;
          $memberArray['manager']=0;
          $memberArray['frontend'][0]="";
          $memberArray['backend'][0]="";
          $memberArray['uiux'][0]="";
          foreach ($userTeams as $member) {
              if($member->id_role==1){
                  $memberArray['manager'] = User::where('id', $member->id_user)->first();
              } else if($member->id_role==2){
                  $memberArray['frontend'][$i] = User::where('id', $member->id_user)->first();
                  $i++;
              } else if($member->id_role==3){
                  $memberArray['backend'][$j] = User::where('id', $member->id_user)->first();
                  $j++;
              } else {
                  $memberArray['uiux'][$k] = User::where('id', $member->id_user)->first();
                  $k++;
              }
           }
           $memberArray['count']['frontend'] = $i;
           $memberArray['count']['backend'] = $j;
           $memberArray['count']['uiux'] = $k;
          return response()->json(['success'=>'true','data'=>$memberArray],200);
      }

      public function kick(Request $request){
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
            'id_user' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $userTeams = UserTeam::where('id_team',$request->id_team)->where('id_user',$request->id_user)->delete();
        return response()->json(['success'=>'true','message'=>'successfully kick member'],200);
      }
}
