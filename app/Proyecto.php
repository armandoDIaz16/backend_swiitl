<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'CATR_PROYECTO';
    protected $primaryKey = 'PK_PROYECTO';
    protected $fillable = ['FK_ANTEPROYECTO', 'FK_DOCENTE', 'FK_ASESOR_EXT'];
}
