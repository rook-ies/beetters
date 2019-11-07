<?php

namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    //protected $casts = [
    //    'email_verified_at' => 'datetime',
    //];

    public function dailyTrackingReport()
    {
    	return $this->hasMany('App\DailyTrackingReport');
    }

    public function dailyScrumReport()
    {
    	return $this->hasMany('App\DailyScrumReport');
    }

    public function poke()
    {
    	return $this->hasMany('App\Poke');
    }

    public function userTeam()
    {
    	return $this->hasMany('App\UserTeam');
    }

    public function trackingHistory(){
      return $this->hasMany('App\TrackingHistory');
    }

}
