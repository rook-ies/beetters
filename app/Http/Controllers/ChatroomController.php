<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Chatroom;
class ChatroomController extends Controller
{
    public function index()
    {
        return Chatroom::all();
    }

    public function show(Chatroom $chatroom)
    {
        return $chatroom;
    }

    public function store(Request $request)
    {
        //$chatroom = Chatroom::create($request->all());
        $validator = Validator::make($request->all(), [
            'room_code' => 'required|unique:chatroom,room_code',
            'room_name' => 'required',
            'business_hour_start' => 'required',
            'business_hour_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $chatroom = new Chatroom;
        $chatroom->room_code = $request->room_code;
        $chatroom->room_name = $request->room_name;
        $chatroom->business_hour_start = $request->business_hour_start;
        $chatroom->business_hour_end = $request->business_hour_end;
        $chatroom->save();
        return response()->json($chatroom, 201);
    }

    public function update(Request $request, Chatroom $chatroom)
    {
        $validator = Validator::make($request->all(), [
            'room_code' => 'required|unique:chatroom,room_code',
            'room_name' => 'required',
            'business_hour_start' => 'required',
            'business_hour_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $chatroom->update($request->all());

        return response()->json($chatroom, 200);
    }

    public function delete(Chatroom $chatroom)
    {
        $chatroom->delete();

        return response()->json(null, 204);
    }


}
