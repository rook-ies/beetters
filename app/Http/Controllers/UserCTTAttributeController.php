<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserCTTAttribute;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserCTTAttributeController extends Controller
{
  public function index()
  {
      return UserCTTAttribute::all();
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'id_online_status' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $userCTTAttribute = new UserCTTAttribute;
      $userCTTAttribute->id_user = Auth::guard('api')->id();
      $userCTTAttribute->id_online_status = $request->id_online_status;
      $userCTTAttribute->save();

      return response()->json($userCTTAttribute,201);
  }

  public function show(UserCTTAttribute $userCTTAttribute)
  {
      return $userCTTAttribute;
  }

  public function update(Request $request,UserCTTAttribute $userCTTAttribute)
  {
      $validator = Validator::make($request->all(), [
          'id_online_status' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $userCTTAttribute->update($request->all());

      return response()->json($userCTTAttribute,200);
  }

  public function delete(UserCTTAttribute $userCTTAttribute)
  {
      $userCTTAttribute->delete();

      return response()->json(null,204);
  }
}
