<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    protected $table='tracking_history';

    protected $fillable=['id_user','start_time','end_time','duration'];
}
