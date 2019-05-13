<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tecnm extends Model{
    protected $fillable = [
        'NOMBRE',
        'ABREVIATURA',
        'CLAVE',
        'ID',
        'FK_TIPO_INSTITUTO',
        'FK_CODIGO_POSTAL',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    protected $table = 'CATR_TECNM';
}
