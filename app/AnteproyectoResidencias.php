<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnteproyectoResidencias extends Model
{
    protected $table = 'CAT_ANTEPROYECTO_RESIDENCIA';

    protected $primaryKey = 'ID_ANTEPROYECTO';

    protected $fillable = ['NOMBRE','PDF','ALUMNO','ESTATUS','AREA_ACADEMICA','AUTOR','EMPRESA','TIPO_ESPECIALIDAD','PERIODO'];
}
