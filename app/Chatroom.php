<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Chatroom extends Model
{
    protected $table = 'chatroom';

    protected $fillable = ['room_code','room_name','business_hour_start', 'business_hour_end'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function message()
    {
    	return $this->hasMany('App\Message');
    }
}
