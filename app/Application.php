<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table='application';

    protected $fillable=['id_app_productivity_type','name','application_file_name','application_icon'];
}
