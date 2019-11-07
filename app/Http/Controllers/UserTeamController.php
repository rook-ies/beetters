<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\UserTeam;
class UserTeamController extends Controller
{
    public function index()
    {
        return UserTeam::all();
        return response()->json(['success'=>'true','data'=>UserTeam::all()],200);
    }

    public function show(UserTeam $userTeam)
    {
        return response()->json(['success'=>'true','data'=>$userTeam],200);
    }

    public function store(Request $request)
    {
        //$userTeam = UserTeam::create($request->all());
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
            'id_role'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $userTeam = new UserTeam;
        $userTeam->id_user = Auth::guard('api')->id();
        $userTeam->id_team = $request->id_team;
        $userTeam->id_role = $request->id_role;
        $userTeam->save();

        return response()->json(['success'=>'true','data'=>$userTeam],201);
    }

    public function update(Request $request, UserTeam $userTeam)
    {
        $validator = Validator::make($request->all(), [
          'id_team' => 'required',
          'id_role'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $userTeam->update($request->all());

        return response()->json(['success'=>'true','data'=>$userTeam],200);
    }

    public function delete(UserTeam $userTeam)
    {
        $userTeam->delete();

        return response()->json(null, 204);
    }
}
