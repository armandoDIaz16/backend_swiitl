<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentacionResidencias extends Model
{
    protected $table = 'documentacion';
    protected $fillable = ['id_alumno','carta_aceptacion','carta_solicitud'];
}
