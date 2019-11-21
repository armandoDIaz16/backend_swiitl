<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoordinadorDepartamentalTutoria
 * @package App
 */
class CoordinadorDepartamentalTutoria extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'FK_USUARIO',
        'FK_AREA_ACADEMICA',
        'ESTADO',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
    ];

    /**
     * @var string
     */
    protected $table = 'TR_COORDINADOR_DEPARTAMENTAL_TUTORIA';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_COORDINADOR';

    /**
     * @var bool
     */
    public $timestamps = false;

}
