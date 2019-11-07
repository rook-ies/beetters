<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poke extends Model
{
    protected $table='poke';

    protected $fillable=['id_team','id_user','content'];

    public function user(){
      return $this->belongsTo('App/User');
    }

    public function team(){
      return $this->belongsTo('App/Team');
    }
}
