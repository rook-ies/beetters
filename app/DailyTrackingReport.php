<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyTrackingReport extends Model
{
    protected $table = 'daily_tracking_report';

    protected $fillable = [
        'idu',
        'productive_value',
        'netral_value',
        'not_productive_value'
    ];
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
