<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aplicacion_Encuesta
 * @package App
 */
class Aplicacion_Encuesta extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'FK_USUARIO',
        'FK_ENCUESTA',
        'FK_TIPO_APLICACION',
        'APLICACION_SEMESTRE',
        'APLICACION_FK_CARRERA',
        'PERIODO',
        'FECHA_APLICACION',
        'FECHA_RESPUESTA',
        'ESTADO',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION'
    ];
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_APLICACION';

    /**
     * @var string
     */
    protected $table = 'TR_APLICACION_ENCUESTA';
}
