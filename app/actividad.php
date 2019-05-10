<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class actividad extends Model
{
    protected $primaryKey = 'PK_ACTIVIDAD';

    public $timestamps = false;

    protected $table = 'ACTIVIDADES';
}
