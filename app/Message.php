<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Message extends Model
{
    protected $table = 'message';

    protected $fillable = ['idc','idu','content'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function chatroom()
    {
    	return $this->belongsTo('App\Chatroom');
    }
}
