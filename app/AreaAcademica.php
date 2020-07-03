<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaAcademica extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'FK_INSTITUCION',
        'NOMBRE',
        'ABREVIATURA',
        'ES_ACADEMICA',
        'ESTADO',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO',
    ];

    /**
     * @var string
     */
    protected $table = 'CAT_AREA_ACADEMICA';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_AREA_ACADEMICA';

    /**
     * @var bool
     */
    public $timestamps = false;
}
