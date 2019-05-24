<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalificacionAlumno extends Model
{
    protected $table = 'CATR_CALIFICACION_ALUMNO';
    public $timestamps = false;
    protected $primaryKey = 'PK_CALIFICACION_ALUMNO';
    protected $fillable = ['CALIFICACION', 'TITULACION', 'OBSERVACIONES',  'FK_ALUMNO','FK_DOCENTE','PERIODO'];
}
