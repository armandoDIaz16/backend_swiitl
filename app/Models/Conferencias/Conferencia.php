<?php

namespace App\Models\Conferencias;

use Illuminate\Database\Eloquent\Model;

class Conferencia extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'TEMA',
        'FECHA',
        'LUGAR',
        'DESCRIPCION',
        'NOMBRE_EXPOSITOR',
        'CURRICULUM_EXPOSITOR',
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
    protected $table = 'CAT_JORNADA';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_JORNADA';

    /**
     * @var bool
     */
    public $timestamps = false;
}
