<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'CATR_DOCENTE';
    protected $primaryKey = 'NUMERO_EMPLEADO_DOCENTE';
    protected $fillable = ['ID_AREA_ACADEMICA', 'ID_PADRE'];
}
