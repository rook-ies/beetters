<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    protected $table='tracking_history';

    protected $fillable=['id_user','start_time','end_time','duration'];

    public function application(){
      return $this->belongsToMany('App\Application');
    }

    public function user(){
      return $this->belongsTo('App\User');
    }
}
