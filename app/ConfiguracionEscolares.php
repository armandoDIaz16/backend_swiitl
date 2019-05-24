<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionEscolares extends Model
{
    protected $table = 'CAT_CONFIGURACION_ESCOLARES';
    public $timestamps = false;
    protected $primaryKey = 'PK_CONFIGURACION_ESCOLARES';
    protected $fillable = ['FOLIO', 'FECHA', 'PERIODO'];
}
