<?php

namespace App\Models\Conferencias;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InvitacionConferenciaDetalle
 * @package App\Models\Tutoria
 */
class InvitacionConferenciaDetalle extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'FK_INVITACION',
        'FK_USUARIO',
        'HORA_ENTRADA',
        'HORA_SALIDA',
        'ASISTENCIA',
        'OBSERVACIONES_JUSTIFICACION',
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
    protected $table = 'CAT_TIPO_ESPACIO';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_DETALLE';

    /**
     * @var bool
     */
    public $timestamps = FALSE;
}
