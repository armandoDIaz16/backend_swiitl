<?php

namespace App\Referencias;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    /**
     * Atributos que pueden modificarse de la tabla.
     *
     * @var array
     */
    protected $fillable = [
        'FK_AREA_ACADEMICA',
        'NOMBRE',
        'DESCRIPCION',
        'MONTO',
        'VIGENCIA_INICIAL',
        'VIGENCIA_FINAL',
        'ES_MONTO_VARIABLE',
        'ES_CANTIDAD_VARIABLE',
        'CLAVE_CONTPAQ',
        'ESTATUS',
        'CLAVE_CONTPAQ_TECNM',
        'FK_VALE',
        'GENERA_DOCUMENTO',

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
    protected $primaryKey = 'PK_CONCEPTO';

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
    protected $table = 'CAT_CONCEPTO';
}
