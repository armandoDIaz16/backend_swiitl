<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model{
    protected $fillable = [
        'NOMBRE',
        'PREFIJO',
        'FK_USUARIO_REGISTRO',
        'FK_CAMPUS',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    protected $table = 'CATR_EDIFICIO';
}
