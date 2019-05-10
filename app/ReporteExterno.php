<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteExterno extends Model
{
    protected $table = 'CAT_REPORTE_EXTERNO';
    public $timestamps = false;
    protected $primaryKey = 'PK_REPORTE_EXTERNO';
    protected $fillable = ['PDF', 'EXTERNO', 'NUMERO', 'ALUMNO', 'PERIODO'];
}
