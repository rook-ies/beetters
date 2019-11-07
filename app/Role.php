<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $table='role';

  protected $fillable=['role_type'];

  public function UserTeam(){
    return $this->hasMany('App/UserTeam');
  }

  public function Application(){
    return $this->belongsToMany('App/Application');
  }
}
