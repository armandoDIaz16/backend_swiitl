<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InscripcionCursoCADO extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_INSCRIPCION_CURSO';

    /**
     * @var string
     */
    protected $table = 'CATTR_INSCRIPCION_CURSO';

}
