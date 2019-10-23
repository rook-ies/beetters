<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $chatroomUser = ChatroomUser::create($request->all());

        return response()->json($chatroomUser, 201);
    }

    public function update(Request $request, ChatroomUser $chatroomUser)
    {
        $chatroomUser->update($request->all());

        return response()->json($chatroomUser, 200);
    }

    public function delete(ChatroomUser $chatroomUser)
    {
        $chatroomUser->delete();

        return response()->json(null, 204);
    }
}
