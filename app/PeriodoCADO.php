<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoCADO extends Model
{
    protected $fillable = [
        'NOMBRE_PERIODO',
        // 'TIPO_PERIODO',
        'FECHA_INICIO',
        'FECHA_FIN',

        // 'ESTADO',

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
    protected $primaryKey = 'PK_PERIODO_CADO';

    /**
     * @var string
     */
    protected $table = 'CAT_PERIODO_CADO';
}
