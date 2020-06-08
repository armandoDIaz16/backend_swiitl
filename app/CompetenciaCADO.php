<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenciaCADO extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_COMPETENCIA_CURSO';

    /**
     * @var string
     */
    protected $table = 'CAT_COMPETENCIAS_CURSO_CADO';

}
