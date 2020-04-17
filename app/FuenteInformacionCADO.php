<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuenteInformacionCADO extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_FUENTE_INFORMACION';

    /**
     * @var string
     */
    protected $table = 'CAT_FUENTE_INFORMACION_CADO';

}
