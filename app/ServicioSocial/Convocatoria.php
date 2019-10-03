<?php

namespace App\ServicioSocial;

use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{
    protected $fillable = [
        'NO_CONTROL_CONV',

        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];

    protected $primaryKey = 'PK_CONVOCATORIA';

    public $timestamps = false;

    protected $table = 'CAT_CONVOCATORIA';

    public function datoConvocatorias(){
        return $this-> hasMany(DatoConvocatoria::Class,'FK_CONVOCATOTIA','PK_CONVOCATORIA');
    }
}
