<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Externo extends Model
{
    protected $table = 'CATR_EXTERNO';
    protected $primaryKey = 'NUMERO_EXTERNO';
    protected $fillable = ['ID_PADRE'];
}
