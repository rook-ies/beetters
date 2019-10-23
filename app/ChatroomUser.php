<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ChatroomUser;
class ChatroomUser extends Model
{
    protected $table = 'chatroom_user';

    protected $fillable = ['idu','idc'];

    /*public function user()
    {
        return $this->belongsTo('User');
    }
    public function chatroom_user()
    {
        return $this->belongsTo('ChatroomUser');
    }*/
}
