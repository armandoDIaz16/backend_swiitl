<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteResidencia extends Model
{
    protected $table = 'CAT_REPORTE_RESIDENCIA';
    protected $primaryKey = 'PK_REPORTE';
    protected $fillable = ['NOMBRE', 'PDF', 'ALUMNO', 'NUMERO','PERIODO'];
}
