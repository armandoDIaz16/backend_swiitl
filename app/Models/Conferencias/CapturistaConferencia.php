<?php

namespace App\Models\Conferencias;

use Illuminate\Database\Eloquent\Model;

class CapturistaConferencia extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'FK_JORNADA',
        'FK_USUARIO',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO',
    ];

    /**
     * @var string
     */
    protected $table = 'TR_CAPTURISTA_CONFERENCIA';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CAPTURISTA';

    /**
     * @var bool
     */
    public $timestamps = false;
}
