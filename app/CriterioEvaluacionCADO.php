<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriterioEvaluacionCADO extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CRITERIO_EVALUACION';

    /**
     * @var string
     */
    protected $table = 'CAT_CRITERIO_EVALUACION_CADO';

}
