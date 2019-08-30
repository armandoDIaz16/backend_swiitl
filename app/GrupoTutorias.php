<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoTutorias
 * @package App
 */
class GrupoTutorias extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'FK_CARRERA',
        'FK_USUARIO',
        'PERIODO',
        'CLAVE',
        'TIPO_GRUPO',
        'EVALUACION',
        'ESTADO',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_GRUPO_TUTORIA';

    /**
     * @var string
     */
    protected $table = 'TR_GRUPO_TUTORIA';
}
