<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationTrackingHistory extends Model
{
    protected $table = 'application_tracking_history';

    protected $fillable = ['id_tracking_history','id_application','start_time','end_time','duration'];
}
