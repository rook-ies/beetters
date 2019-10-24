<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obstacle extends Model
{
    //
    protected $table = 'obstacle';

    protected $fillable =['id_daily_scrum_report','content'];
}
