<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserCTTAttribute;

class UserCTTAttributeController extends Controller
{
  public function index()
  {
      return UserCTTAttribute::all();
  }

  public function store(Request $request)
  {
      $userCTTAttribute = UserCTTAttribute::create($request->all());

      return response()->json($userCTTAttribute,201);
  }

  public function show(UserCTTAttribute $userCTTAttribute)
  {
      return $userCTTAttribute;
  }

  public function update(Request $request,UserCTTAttribute $userCTTAttribute)
  {
      $userCTTAttribute->update($request->all());

      return response()->json($userCTTAttribute,200);
  }

  public function delete(UserCTTAttribute $userCTTAttribute)
  {
      $userCTTAttribute->delete();

      return response()->json(null,204);
  }
}
