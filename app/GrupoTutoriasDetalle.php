<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoTutoriasDetalle extends Model
{
    protected $fillable = [
        'FK_GRUPO',
        'FK_USUARIO',
        'ESTADO',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    public $timestamps = false;

    protected $primaryKey = 'PK_GRUPO_TUTORIA_DETALLE';

    protected $table = 'TR_GRUPO_TUTORIA_DETALLE';
}
