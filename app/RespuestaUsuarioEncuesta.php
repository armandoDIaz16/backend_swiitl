<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaUsuarioEncuesta extends Model
{
    protected $fillable = [
        'FK_RESPUESTA_POSIBLE',
        'FK_APLICACION_ENCUESTA',
        'RESPUESTA_ABIERTA',
        'ESTADO',
        'ORDEN',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    public $timestamps = false;

    protected $primaryKey = 'PK_RESPUESTA_USUARIO_ENCUESTA';

    protected $table = 'TR_RESPUESTA_USUARIO_ENCUESTA';
}
