<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message;
class Chatroom extends Model
{
    protected $table = 'chatroom';

    protected $fillable = ['room_code','room_name','business_hour_start', 'business_hour_end'];

    /*public function message()
    {
        return $this->hasMany('Message');
    }
    public function chatroom_user()
    {
        return $this->hasMany('ChatroomUser');
        // return $this->hasMany('ChatroomUser', 'idu');
    }*/
}
