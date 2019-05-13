<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteDocente extends Model
{
    protected $table = 'CAT_REPORTE_DOCENTE';
    protected $primaryKey = 'PK_REPORTE_DOCENTE';
    protected $fillable = ['PDF', 'DOCENTE', 'NUMERO', 'ALUMNO', 'PERIODO'];
}
