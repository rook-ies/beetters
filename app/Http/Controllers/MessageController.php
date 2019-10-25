<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Message;
use Validator;
class MessageController extends Controller
{
    public function index()
    {
        return Message::all();
    }

    public function show(Message $message)
    {
        return $message;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_chatroom' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $message = new Message;
        $message->id_user = Auth::guard('api')->id();
        $message->id_chatroom = $request->id_chatroom;
        $message->content = $request->content;
        $message->save();
        //$message = Message::create($request->all());
        //$message->save();
        return response()->json($message, 201);
    }

    public function update(Request $request, Message $message)
    {
        $validator = Validator::make($request->all(), [
            'id_chatroom' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $message->update($request->all());

        return response()->json($message, 200);
    }

    public function delete(Message $message)
    {
        $message->delete();

        return response()->json(null, 204);
    }
}
