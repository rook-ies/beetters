<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Poke;
class PokeController extends Controller
{
  public function index()
  {
      return response()->json(['success'=>'true','data'=>Poke::all()],201);
  }

  public function show(Poke $poke)
  {
      return response()->json(['success'=>'true','data'=>$poke],201);
  }

  public function store(Request $request)
  {
      //$poke = Poke::create($request->all());
      $validator = Validator::make($request->all(), [
          'content' => 'required',
          'id_team' => 'required',
          'id_user'=>'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 200);
      }

      $poke = new Poke;
      $poke->content = $request->content;
      $poke->id_user = $request->id_user;
      $poke->id_team = $request->id_team;
      $poke->save();
      return response()->json(['success'=>'true','data'=>$poke],201);
  }

  public function update(Request $request, Poke $poke)
  {
      $validator = Validator::make($request->all(), [
          'content' => 'required',
          'id_team' => 'required',
          'id_user'=>'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 200);
      }
      $poke->update($request->all());

      return response()->json($poke, 200);
  }

  public function delete(Poke $poke)
  {
      $poke->delete();

      return response()->json(null, 204);
  }
}
