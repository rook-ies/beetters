<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomUser extends Model
{
    protected $table = 'chatroom_user';

    protected $fillable = ['idu','idc'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function chatroom()
    {
    	return $this->belongsTo('App\Chatroom');
    }
}
