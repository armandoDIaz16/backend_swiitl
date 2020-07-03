<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aplicacion_Encuesta_Detalle
 * @package App
 */
class Aplicacion_Encuesta_Detalle extends Model
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
    protected $primaryKey = 'PK_APLICACION_ENCUESTA_DETALLE';

    /**
     * @var string
     */
    protected $table = 'TR_APLICACION_ENCUESTA_DETALLE';
}
