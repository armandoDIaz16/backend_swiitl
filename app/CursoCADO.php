<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoCADO extends Model
{


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_CAT_CURSO_CADO';

    /**
     * @var string
     */
    protected $table = 'CAT_CURSO_CADO';
}
