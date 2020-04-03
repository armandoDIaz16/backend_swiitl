<?php

namespace App\Referencias;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    /**
     * Atributos que pueden modificarse de la tabla.
     *
     * @var array
     */
    protected $fillable = [
        'FK_USUARIO',
        'FK_CONCEPTO',
        'FECHA_GENERADA',
        'FECHA_EXPIRACION',
        'ESTATUS_REFERENCIA'.
        'MONTO',
        'NUMERO_REF_BANCO',
        'FECHA_PAGO',
        'TIPO_PAGO',
        'CANTIDAD_SOLICITADA',
        'MONTO_SISTEMA',
        'MONTO_PAGADO',

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
    protected $primaryKey = 'PK_REFERENCIA';

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
    protected $table = 'TR_REFERENCIA';
}
