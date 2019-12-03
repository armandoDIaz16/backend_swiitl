<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 * @package App
 */
class Rol extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'FK_SISTEMA',
        'NOMBRE',
        'ABREVIATURA',
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
    protected $primaryKey = 'PK_ROL';

    /**
     * @var string
     */
    protected $table = 'PER_CAT_ROL';
}
