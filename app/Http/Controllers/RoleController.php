<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Role;
class RoleController extends Controller
{
  public function index()
  {
      return response()->json(['success'=>'true','data'=>Role::all()],201);
  }

  public function show(Role $role)
  {
      return response()->json(['success'=>'true','data'=>$role],201);
  }

  public function store(Request $request)
  {
      //
      $validator = Validator::make($request->all(), [
          'role_type' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $role = Role::create($request->all());
      return response()->json(['success'=>'true','data'=>$role],201);
  }

  public function update(Request $request, Role $role)
  {
      $validator = Validator::make($request->all(), [
          'role_type' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }
      $role->update($request->all());
      return response()->json(['success'=>'true','data'=>$role],200);
  }

  public function delete(Role $role)
  {
      $role->delete();

      return response()->json(['success'=>'true','message'=>'successfully delete'],200);
  }
}
