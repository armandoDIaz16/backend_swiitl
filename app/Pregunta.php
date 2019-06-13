<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    //
    protected $fillable = [
        'ORDEN',
        'PLANTEAMIENTO',
        'TEXTO_GUIA',
        'FK_TIPO_PREGUNTA',
        'FK_SECCION',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    public $timestamps = false;

    protected $primaryKey = 'PK_PREGUNTA';

    protected $table = 'CATR_PREGUNTA';
}
