<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineStatus extends Model
{
    protected $table='online_status';

    protected $fillable=['status'];

    public function userCTTAttribute(){
      return $this->hasMany('App\UserCTTAttribute');
    }
}
