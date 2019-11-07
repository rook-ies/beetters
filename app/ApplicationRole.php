<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationRole extends Model
{
    protected $table='application_role';

    protected $fillable=['id_application','id_role'];
}
