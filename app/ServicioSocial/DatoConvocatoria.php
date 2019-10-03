<?php

namespace App\ServicioSocial;

use Illuminate\Database\Eloquent\Model;

class DatoConvocatoria extends Model
{
    protected $fillable = [
        'FK_CONVOCATOTIA',
        'TURNO',
        'FK_ESPACIO_CONVOCATORIA',
        'HORARIO_INICIO',
        'HORARIO_FIN',
        'FECHA_CONVOCATORIA',
        'PERIODO',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    protected $primaryKey = 'PK_DATO_CONVOCATORIA';

    public $timestamps = false;
    
    protected $table = 'CATR_DATO_CONVOCATORIA';

    public function convocatoria()
    {
        return $this->belongsTo(Convocatoria::Class,'FK_CONVOCATOTIA','PK_CONVOCATORIA');
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::Class,'FK_ESPACIO_CONVOCATORIA');
    }
}
