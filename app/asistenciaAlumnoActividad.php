<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class asistenciaAlumnoActividad extends Model
{
    protected $table = 'ASISTENCIA_ALUMNO_ACTIVIDAD';

    protected $primaryKey = 'PK_ASISTENCIA_ALUMNO_ACTIVIDAD';

    public $timestamps = false;
}
