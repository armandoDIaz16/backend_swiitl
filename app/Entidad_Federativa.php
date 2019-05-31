<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad_Federativa extends Model
{
    protected $fillable = [
      'NOMBRE',
      'ESTADO',
      'FK_USUARIO_REGISTRO',
      'FECHA_REGISTRO',
      'FK_USUARIO_MODIFICACION',
      'FECHA_MODIFICACION',
      'BORRADO'
    ];
    protected $table = 'CAT_ENTIDAD_FEDERATIVA';
}
