<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboralCVCADO extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_EXPERIENCIA_LABORAL_CV';

    /**
     * @var string
     */
    protected $table = 'CAT_EXPERIENCIA_LABORAL_CV_CADO';

}
