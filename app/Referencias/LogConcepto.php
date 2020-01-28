<?php

namespace App\Referencias;

use Illuminate\Database\Eloquent\Model;

class LogConcepto extends Model
{
    /**
     * Atributos que pueden modificarse de la tabla.
     *
     * @var array
     */
    protected $fillable = [
        'FK_CONCEPTO',
        'MONTO_ANTERIOR',
        'MONTO_NUEVO',

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
    protected $primaryKey = 'PK_LOG_CONCEPTO';

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
    protected $table = 'LOG_CONCEPTO';
}
