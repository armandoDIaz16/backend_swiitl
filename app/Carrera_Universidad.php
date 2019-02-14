<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera_Universidad extends Model
{
    protected $fillable = [
        'NOMBRE',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    protected $table = 'CAT_CARRERA_UNIVERSIDAD';
}
