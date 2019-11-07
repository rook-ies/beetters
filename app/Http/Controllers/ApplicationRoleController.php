<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\ApplicationRole;
class ApplicationRoleController extends Controller
{
    public function index()
    {
        return response()->json(['success'=>'true','data'=>ApplicationRole::all()],200);
    }

    public function show(ApplicationRole $applicationRole)
    {
        return response()->json(['success'=>'true','data'=>$applicationRole],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_role' => 'required',
            'id_application' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $applicationRole = ApplicationRole::create($request->all());
        return response()->json(['success'=>'true','data'=>$applicationRole],201);
    }

    public function update(Request $request, ApplicationRole $applicationRole)
    {
        $validator = Validator::make($request->all(), [
            'id_role' => 'required',
            'id_application' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $applicationRole->update($request->all());

        return response()->json(['success'=>'true','data'=>$applicationRole],200);
    }

    public function delete(ApplicationRole $applicationRole)
    {
        $applicationRole->delete();

        return response()->json(['success'=>'true','message'=>'successfully delete'],200);
    }
}
