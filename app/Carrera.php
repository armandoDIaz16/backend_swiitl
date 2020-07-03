<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Carrera
 * @package App
 */
class Carrera extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'NOMBRE',
        'ABREVIATURA',
        'CLAVE_TECNM',
        'CLAVE_TECLEON',
        'ESTADO',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION'
    ];

    /**
     * @var string
     */
    protected $table = 'CAT_CARRERA';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CARRERA';

}
