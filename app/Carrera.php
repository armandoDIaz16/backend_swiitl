<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = [
        'CLAVE',
        'NOMBRE',
        'ESTADO',
        'FK_AREA_ACADEMICA',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    protected $table = 'CATR_CARRERA';



}
