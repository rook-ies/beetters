<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTeam extends Model
{
    protected $table = 'user_team';

    protected $fillable = ['id_user','id_team','id_role'];

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function role(){
      return $this->belongsTo('App\Role');
    }

    public function team(){
      return $this->belongsTo('App\Team');
    }
}
