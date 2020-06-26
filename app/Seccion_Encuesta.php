<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion_Encuesta extends Model
{
    //
    protected $fillable = [
        'NOMBRE_SECCION',
        'NUMERO_SECCION',
        'OBJETIVO',
        'INSTRUCCIONES',
        'FK_ENCUESTA',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    public $timestamps = false;

    protected $primaryKey = 'PK_SECCION';

    protected $table = 'CAT_SECCION';
}
