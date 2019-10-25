<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomUser extends Model
{
    protected $table = 'chatroom_user';

    protected $fillable = ['id_user','id_chatroom'];

}
