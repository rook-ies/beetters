<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppProductivityType extends Model
{
    //
    protected $table='app_productivity_type';

    protected $fillable=['name'];
}
