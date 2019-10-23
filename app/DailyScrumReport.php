<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyScrumReport extends Model
{
    protected $table = 'daily_scrum_report';

    protected $fillable = ['idu','idc','last_24_hour_activities','next_24_hour_activities'];
}
