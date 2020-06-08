<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFormacionCVCADO extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_TIPO_FORMACION_ACADEMICA';

    /**
     * @var string
     */
    protected $table = 'CAT_TIPO_FORMACION_ACADEMICA_CADO';

}
