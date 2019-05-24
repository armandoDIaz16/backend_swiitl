<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartaFinalizacion extends Model
{
    protected $table = 'CAT_CARTA_FINALIZACION_RESIDENCIAS';
    public $timestamps = false;
    protected $primaryKey = 'PK_CARTA_FINALIZACION_RESIDENCIAS';
    protected $fillable = ['CARTA', 'FK_ALUMNO', 'PERIODO'];
}
