<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipacionInstructorCVCADO extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'PK_PARTICIPACION_INSTRUCTOR_CV';

    /**
     * @var string
     */
    protected $table = 'CAT_PARTICIPACION_INSTRUCTOR_CV_CADO';
}
