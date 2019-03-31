<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
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
    protected $table = 'CATR_CIUDAD';
}
