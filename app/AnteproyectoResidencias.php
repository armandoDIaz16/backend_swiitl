<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnteproyectoResidencias extends Model
{
    protected $connection = 'sqlsrv3';
    protected $table = 'ante';

    protected $fillable = ['Nombre','AreaAcademica','Empresa','TipoEspecialidad'];
}
