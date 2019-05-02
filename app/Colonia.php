<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    protected $fillable = [
      'PK_COLONIA',
      'NOMBRE',
      'FK_USUARIO_REGISTRO',
      'FECHA_REGISTRO',
      'FK_USUARIO_MODIFICACION',
      'FECHA_MODIFICACION',
      'BORRADO'
    ];
    protected $table = 'CATR_COLONIA';
}
