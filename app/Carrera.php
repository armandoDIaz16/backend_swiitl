<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = [
        'NOMBRE',
        'ABREVIATURA',
        'CLAVE_TECNM',
        'CLAVE_TECLEON',
        'ESTADO',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION'
    ];

    protected $table = 'CAT_CARRERA';



}
