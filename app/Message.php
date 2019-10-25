<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Message extends Model
{
    protected $table = 'message';

    protected $fillable = ['id_chatroom','id_user','content'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function chatroom()
    {
    	return $this->belongsTo('App\Chatroom');
    }
}
