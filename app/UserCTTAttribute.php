<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCTTAttribute extends Model
{
    protected $table='user_c_t_t_attribute';

    protected $fillable = ['id_user','id_online_status'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function userCTTAttribute(){
      return $this->hasOne('App\OnlineStatus');
    }
}
