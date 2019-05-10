<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeTecnico extends Model
{
    protected $table = 'CAT_INFORME_ALUMNO';
    public $timestamps = false;
    protected $primaryKey = 'PK_INFORME_ALUMNO';
    protected $fillable = ['INFORME','FK_ALUMNO','PERIODO'];
}
