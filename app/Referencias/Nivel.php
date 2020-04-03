<?php

namespace App\Referencias;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nivel
 * @package App\Referencias
 */
class Nivel extends Model
{
    /**
     * Atributos que pueden modificarse de la tabla.
     *
     * @var array
     */
    protected $fillable = [
        'NIVEL',
        'NOMBRE',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    /**
     * Llave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'PK_NIVEL';

    /**
     * No usar las columnas created_at o updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'CAT_NIVEL';
}
