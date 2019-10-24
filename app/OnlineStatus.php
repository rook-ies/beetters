<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineStatus extends Model
{
    protected $table='online_status';

    protected $fillable=['status'];
}
