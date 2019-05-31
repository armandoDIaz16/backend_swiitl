<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Pregunta extends Model
{
    protected $fillable = [
        'NOMBRE_TIPO_PREGUNTA',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    public $timestamps = false;

    protected $primaryKey = 'PK_TIPO_PREGUNTA';

    protected $table = 'CAT_TIPO_PREGUNTA';
}
