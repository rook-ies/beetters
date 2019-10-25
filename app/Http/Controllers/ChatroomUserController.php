<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\ChatroomUser;
class ChatroomUserController extends Controller
{
    public function index()
    {
        return ChatroomUser::all();
    }

    public function show(ChatroomUser $chatroomUser)
    {
        return $chatroomUser;
    }

    public function store(Request $request)
    {
        //$chatroomUser = ChatroomUser::create($request->all());
        $validator = Validator::make($request->all(), [
            'id_chatroom' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $chatroomUser = new ChatroomUser;
        $chatroomUser->id_user = Auth::guard('api')->id();
        $chatroomUser->id_chatroom = $request->id_chatroom;
        $chatroomUser->save();
        return response()->json($chatroomUser, 201);
    }

    public function update(Request $request, ChatroomUser $chatroomUser)
    {
        $validator = Validator::make($request->all(), [
            'id_chatroom' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $chatroomUser->update($request->all());

        return response()->json($chatroomUser, 200);
    }

    public function delete(ChatroomUser $chatroomUser)
    {
        $chatroomUser->delete();

        return response()->json(null, 204);
    }
}
