<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Role;
class RoleController extends Controller
{
  public function index()
  {
      return Role::all();
  }

  public function show(Role $role)
  {
      return $role;
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'role_type' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 200);
      }

      $role = Role::create($request->all());
      return response()->json($role, 201);
  }

  public function update(Request $request, Role $role)
  {
      $validator = Validator::make($request->all(), [
          'role_type' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 200);
      }
      $role->update($request->all());

      return response()->json($role, 200);
  }

  public function delete(Role $role)
  {
      $role->delete();

      return response()->json(null, 204);
  }
}
