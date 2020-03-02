<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoCADO extends Model
{


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_PERIODO_CADO';

    /**
     * @var string
     */
    protected $table = 'CAT_PERIODO_CADO';
}
