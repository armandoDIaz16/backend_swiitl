<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class asistenteActividad extends Model
{
    protected $table = 'ASISTENTES_ACTIVIDAD';

    protected $primaryKey = 'PK_ASISTENTE_ACTIVIDAD';

    public $timestamps = false;
}
