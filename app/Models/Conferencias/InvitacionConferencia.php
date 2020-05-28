<?php

namespace App\Models\Conferencias;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InvitacionConferencia
 * @package App\Models\Tutoria
 */
class InvitacionConferencia extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'FK_JORNADA',
        'FK_CARRERA',
        'TIPO_INVITACION',
        'SEMESTRE',
        'FECHA_INVITACION',
        'ESTADO',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    /**
     * @var string
     */
    protected $table = 'TR_INVITACION_CONFERENCIA';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_INVITACION';

    /**
     * @var bool
     */
    public $timestamps = FALSE;
}
