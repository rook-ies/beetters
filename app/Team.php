<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Team extends Model
{
    protected $table = 'team';

    protected $fillable = ['room_code','room_name','business_hour_start', 'business_hour_end'];

    public function userTeam()
    {
    	return $this->hasMany('App\UserTeam');
    }

    public function poke(){
      return $this->hasMany('App\Poke');
    }

    public function dailyScrumReport(){
      return $this->hasMany('App\DailyScrumReport');
    }
}
