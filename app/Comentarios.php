<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    protected $table = 'CATR_COMENTARIO_REPORTE';
    protected $primaryKey = 'PK_COMENTARIO';
    protected $fillable = ['FK_REPORTE','FK_USUARIO','COMENTARIO'];
}
