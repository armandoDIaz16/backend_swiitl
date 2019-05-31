<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alumnoCredito extends Model
{
    protected $table = 'ALUMNO_CREDITO';

    protected $primaryKey = 'PK_ALUMNO_CREDITO';

    public $timestamps = false;
}
