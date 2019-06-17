<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta_Posible extends Model
{
    //
    protected $fillable = [
        'RESPUESTA',
        'FK_PREGUNTA',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    public $timestamps = false;

    protected $primaryKey = 'PK_RESPUESTA_POSIBLE';

    protected $table = 'CATR_RESPUESTA_POSIBLE';
}
