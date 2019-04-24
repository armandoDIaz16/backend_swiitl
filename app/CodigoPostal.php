<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoPostal extends Model
{
    protected $fillable = [
      'PK_NUMERO_CODIGO_POSTAL',
      'FK_CIUDAD',
      'FK_USUARIO_REGISTRO',
      'FECHA_REGISTRO',
      'FK_USUARIO_MODIFICACION',
      'FECHA_MODIFICACION',
      'BORRADO'
    ];
    protected $table = 'CATR_CODIGO_POSTAL';
}
