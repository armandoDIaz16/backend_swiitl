<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'CATR_ALUMNO';
    protected $primaryKey = 'NUMERO_CONTROL';
    protected $fillable = [];
}
