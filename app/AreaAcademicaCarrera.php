<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaAcademicaCarrera extends Model
{
    /**
     * @var string
     */
    protected $table = 'TR_AREA_ACADEMICA_CARRERA';

    /**
     * @var string
     */
    protected $primaryKey = 'PK_AREA_ACADEMICA_CARRERA';

    /**
     * @var bool
     */
    public $timestamps = false;
}
