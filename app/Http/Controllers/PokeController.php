<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Poke;
use App\UserTeam;
use App\team;
use App\User;
class PokeController extends Controller
{

  public function show(Poke $poke)
  {
      return response()->json(['success'=>'true','data'=>$poke],201);
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'id_team' => 'required',
          'id_user'=>'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 200);
      }

      $query = UserTeam::where('id_team',$request->id_team)->first()->id_user;

      $manager = User::where('id',$query)->first();
      $team = Team::where('id',$request->id_team)->first();

      $poke = new Poke;
      $poke->content = $manager->name." mempoke anda di team ".$team->room_name;
      $poke->id_user = $request->id_user;
      $poke->id_team = $request->id_team;
      $poke->save();
      return response()->json(['success'=>'true','data'=>$poke],201);
  }

}
