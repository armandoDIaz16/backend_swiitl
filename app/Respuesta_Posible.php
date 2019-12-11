<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Respuesta_Posible
 * @package App
 */
class Respuesta_Posible extends Model
{
    //
    /**
     * @var array
     */
    protected $fillable = [
        'RESPUESTA',
        'FK_PREGUNTA',
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
    protected $primaryKey = 'PK_RESPUESTA_POSIBLE';

    /**
     * @var string
     */
    protected $table = 'CAT_RESPUESTA_POSIBLE';
}
