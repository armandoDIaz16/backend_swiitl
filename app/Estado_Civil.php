<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Estado_Civil
 * @package App
 */
class Estado_Civil extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
      'NOMBRE',
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
    protected $table = 'CAT_ESTADO_CIVIL';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_ESTADO_CIVIL';
}
