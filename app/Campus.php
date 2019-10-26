<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model{
    protected $fillable = [
        'NOMBRE',
        'FK_TECNOLOGICO',
        'FK_USUARIO_REGISTRO',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    public $timestamps = false;

    protected $table = 'CAT_CAMPUS';
}
