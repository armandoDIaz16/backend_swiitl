<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoInstituto extends Model{
    protected $fillable = [
        'NOMBRE',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    protected $table = 'CAT_TIPO_INSTITUTO';
}
