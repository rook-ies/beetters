<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    protected $table = 'chatroom';

    protected $fillable = ['room_code','name','business_hour_start, business_hour_end'];
}
