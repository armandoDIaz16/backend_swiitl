<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenios extends Model
{
    protected $table = 'CAT_INFO_EMPRESA';
    public $timestamps = false;
    protected $primaryKey = 'PK_INFO_EMPRESA';
    protected $fillable = ['NOMBRE_EMPRESA','NOMBRE_REPRESENTANTE','NO_ACTA_CONSTITUTIVA','FECHA_FIRMA','NOMBRE_NOTARIO',
        'NO_NOTARIA','ENTIDAD_FEDERATIVA','FECHA_REGISTRO_E','FOLIO_MERCANTIL','NO_VOLUMEN','OBJETO_SOCIAL','NO_ESCRITURA','FECHA_NOTARIO',
        'NOMBRE_NOTARIO_NOTARIO','NO_NOTARIA_NOTARIO','ENTIDAD_FEDERATIVA_NOTARIO','NO_RFC','DIR_EMPRESA','NOMBRE_TESTIGO','LOGO_EMPRESA'];
}
