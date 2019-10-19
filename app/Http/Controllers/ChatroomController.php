<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $chatroom = Chatroom::create($request->all());

        return response()->json($chatroom, 201);
    }

    public function update(Request $request, Chatroom $chatroom)
    {
        $chatroom->update($request->all());

        return response()->json($chatroom, 200);
    }

    public function delete(Chatroom $chatroom)
    {
        $chatroom->delete();

        return response()->json(null, 204);
    }
}
