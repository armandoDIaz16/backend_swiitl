<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicacion_Encuesta extends Model
{
    protected $fillable = [
        'FECHA_APLICACION',
        'FK_USUARIO',
        'FK_ENCUESTA',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    public $timestamps = false;

    protected $primaryKey = 'PK_APLICACION_ENCUESTA';

    protected $table = 'TR_APLICACION_ENCUESTA';
}
