<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    //
    protected $fillable = [
        'NOMBRE',
        'OBJETIVO',
        'INSTRUCCIONES',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    public $timestamps = false;

    protected $primaryKey = 'PK_ENCUESTA';

    protected $table = 'CAT_ENCUESTA';
}
