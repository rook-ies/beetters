<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Chatroom;
class Message extends Model
{
    protected $table = 'message';

    protected $fillable = ['idc','idu','content'];

    /*public function user()
    {
        return $this->belongsTo('User');
    }
    public function chatroom()
    {
        return $this->belongsTo('Chatroom');
    }*/
}
