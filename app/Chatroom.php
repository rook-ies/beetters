<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Chatroom extends Model
{
    protected $table = 'chatroom';

    protected $fillable = ['room_code','room_name','business_hour_start', 'business_hour_end'];

    public function chatroomUser()
    {
    	return $this->hasMany('App\ChatroomUser');
    }
    public function message()
    {
    	return $this->hasMany('App\Message');
    }
}
