<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentacionResidencias extends Model
{
    protected $table = 'CAT_DOCUMENTACION';

    protected $primaryKey = 'PK_DOCUMENTACION';

    protected $fillable = ['ALUMNO','CARTA_ACEPTACION','SOLICITUD','PERIODO','CARTA_FINALIZACION'];
}
