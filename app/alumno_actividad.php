<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alumno_actividad extends Model
{
    protected $primaryKey = 'PK_ALUMNO_ACTIVIDAD';

    public $timestamps = false;

    protected $table = 'ALUMNO_ACTIVIDAD';
}
