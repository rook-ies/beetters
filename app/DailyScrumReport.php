<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyScrumReport extends Model
{
    protected $table = 'daily_scrum_report';

    protected $fillable = ['id_user','id_team','last_24_hour_activities','next_24_hour_activities'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function team()
    {
    	return $this->belongsTo('App\Team');
    }

    public function obstacle(){
      return $this->hasMany('App\Obstacle');
    }
}
