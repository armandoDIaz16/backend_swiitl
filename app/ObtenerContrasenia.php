<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ObtenerContrasenia
 * @package App
 */
class ObtenerContrasenia extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'FK_USUARIO',
        'TOKEN',
        'CLAVE_ACCESO',
        'FECHA_GENERACION',
        'ESTADO',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'BORRADO'
    ];

    /**
     * @var string
     */
    protected $table = 'PER_TR_OBTENER_CONTRASENIA';

    /**
     * @var bool
     */
    public $timestamps = false;

    protected $primaryKey = 'PK_OBTENER_CONTRASENIA';
}
