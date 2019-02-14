<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_Civil extends Model
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
    protected $table = 'CAT_ESTADO_CIVIL';
}
